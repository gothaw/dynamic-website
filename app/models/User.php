<?php

/**
 *                              Class User
 *                              Model for user. Allows for logging in, registering and logging out user.
 *                              Also includes functionality to create, edit and delete users and checking user permissions.
 */
class User
{
    private $_database;
    private $_data;
    private $_sessionName;
    private $_cookieName;
    private $_isLoggedIn;

    /**
     *                          User constructor.
     * @param                   $user {username or id}
     * @desc                    Constructs the user. If user name or id is provided it finds specific user in the database.
     *                          Alternatively, it logs user in if user id is already stored in session or user hash is stored in cookie.
     */
    public function __construct($user = null)
    {
        $this->_database = Database::getInstance();
        $this->_sessionName = Config::get('session/session_name');
        $this->_cookieName = Config::get('remember/cookie_name');

        if (Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {

            // Logs user in using hash stored in cookie i.e. remember me functionality.
            $hash = Cookie::get(Config::get('remember/cookie_name'));
            $hashCheck = Database::getInstance()->select('user_session', ['us_hash', '=', $hash]);

            if ($hashCheck->getResultRowCount()) {

                $this->findUser($hashCheck->getResultFirstRecord()['user_id']);
                $this->loginUser();
            }
        } else if (!$user) {

            // Checks if user is signed by getting user id from the session.
            if (Session::exists($this->_sessionName)) {

                $user = Session::get($this->_sessionName);

                if ($this->findUser($user)) {
                    // Logs user in
                    $this->_isLoggedIn = true;
                }
            }
        } else {
            // Finds user if id or username were provided.
            $this->findUser($user);
        }
    }

    /**
     * @method              getData
     * @desc                Getter for _data field.
     * @return              mixed
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * @method          getId
     * @desc            Gets user id from _data field.
     * @return          int
     */
    public function getId()
    {
        return $this->_data['u_id'];
    }

    /**
     * @method              isLoggedIn
     * @desc                Getter for _isLoggedIn field.
     * @return              bool
     */
    public function isLoggedIn()
    {
        return $this->_isLoggedIn;
    }


    /**
     * @method              hasPermission
     * @param               $key {permission name as a string e.g. 'admin', 'moderator'}
     *                      Method checks if user permissions ($key) by selecting relevant record from user_group table, described by u_group_id.
     *                      It decodes the JSON u_permissions field using json_decode.
     * @return              bool
     */
    public function hasPermission($key)
    {
        $group = $this->_database->select('user_group', ['u_group_id', '=', $this->_data['u_group_id']]);

        if ($group->getResultRowCount()) {

            $permissionsJSON = $group->getResultFirstRecord()['u_permissions'];
            $permissions = json_decode($permissionsJSON, true);

            return isset($permissions[$key]);
        }
        return false;
    }

    /**
     * @method              createUser
     * @param               $userDetails {user details as an associative array}
     * @throws              Exception
     * @desc                Method inserts user into the database using insert method from Database object.
     *                      If user cannot be created an exception is thrown.
     */
    public function createUser($userDetails)
    {
        if (!$this->_database->insert('user', $userDetails)) {
            throw new Exception('There was a problem creating an account.');
        }
    }

    /**
     * @method              deleteUser
     * @param               $userId
     * @desc                Deletes user from the database.
     * @throws              Exception
     */
    public function deleteUser($userId)
    {
        if (!$this->_database->delete('user', ['u_id', '=', $userId])) {
            throw new Exception('There was a problem deleting the user.');
        }
    }

    /**
     * @method              findUser
     * @param               $user {username as string or id as integer}
     * @desc                Method gets the user record for a given username or id. It returns true if user has been found and false if not.
     *                      It also sets _data if user is found.
     * @return              bool
     */
    private function findUser($user = null)
    {
        if ($user) {

            $field = (is_numeric($user)) ? 'u_id' : 'u_username';
            $data = $this->_database->select('user', [$field, '=', $user]);

            if ($data->getResultRowCount()) {
                $this->_data = $data->getResultFirstRecord();
                return true;
            }
        }
        return false;
    }

    /**
     * @method              updateUser
     * @param               $fields {fields to be updated in the database as an associative array}
     * @param               $id {user id}
     * @desc                Method updates row in the database using update method. If user id is not provided it updates current user, otherwise it updates user with given id.
     * @throws              Exception
     */
    public function updateUser($fields = [], $id = null)
    {
        if (!$id && $this->isLoggedIn()) {
            $id = $this->_data['u_id'];
        }

        if (!$this->_database->update('user', 'u_id', $id, $fields)) {
            throw new Exception('There was a problem updating your account details.');
        }
    }

    /**
     * @method              loginUser
     * @param               $username {string}
     * @param               $password {string}
     * @param               $rememberUser {bool}
     * @desc                Method logs user in. If no name and password is provided and _data field is not empty the user is logged in (cookie remember me functionality).
     *                      Alternatively, if user is set and password in database matches password provided in login form, user is logged in.
     *                      The method also included functionality for remember me checkbox, which generates a new cookie hash that is stored in the database or gets the hash from the database if it exists.
     * @return              bool
     */
    public function loginUser($username = null, $password = null, $rememberUser = false)
    {
        if (!$username && !$password && !empty($this->_data)) {

            // Login using remember me cookie.
            Session::add($this->_sessionName, $this->_data['u_id']);
            $this->_isLoggedIn = true;
            return true;

        } else {

            // Default login functionality.
            $user = $this->findUser($username);
            if ($user) {

                if ($this->_data['u_password'] === Hash::generateHash($password, $this->_data['u_salt'])) {

                    // Password matches and adds u_id to the session.
                    Session::add($this->_sessionName, $this->_data['u_id']);

                    if ($rememberUser) {

                        $hashCheck = $this->_database->select('user_session', ['user_id', '=', $this->_data['u_id']]);

                        if (!$hashCheck->getResultRowCount()) {

                            // Inserts cookie hash to the Database.
                            $hash = Hash::generateFromUniqueId();
                            $this->_database->insert('user_session', [
                                'user_id' => $this->_data['u_id'],
                                'us_hash' => $hash
                            ]);
                        } else {

                            // Gets cookie has from the Database.
                            $hash = $hashCheck->getResultFirstRecord()['us_hash'];
                        }
                        Cookie::add($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
                    }
                    $this->_isLoggedIn = true;
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @method              logoutUser
     * @desc                Logs the user out by deleting _sessionName from the session.
     *                      It also deletes the cookie and the session hash from the user_session table in the database.
     */
    public function logoutUser()
    {
        $this->_database->delete('user_session', ['user_id', '=', $this->_data['u_id']]);
        $this->_isLoggedIn = false;

        Session::delete($this->_sessionName);
        Cookie::delete($this->_cookieName);
    }
}
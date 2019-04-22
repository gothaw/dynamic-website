<?php

class User
{
    private $_database;
    private $_data;
    private $_sessionName;
    private $_cookieName;
    private $_isLoggedIn;

    /**
     * User constructor.
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
     * @method              isLoggedIn
     * @desc                Getter for _isLoggedIn field.
     * @return              bool
     */
    public function isLoggedIn()
    {
        return $this->_isLoggedIn;
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

        Session::delete($this->_sessionName);
        Cookie::delete($this->_cookieName);
    }
}
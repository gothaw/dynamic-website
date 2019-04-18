<?php

class User
{
    // Database property
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

        if (!$user) {
            if (Session::exists($this->_sessionName)) {
                // Gets user id from the session
                $user = Session::get($this->_sessionName);

                if ($this->findUser($user)) {
                    // Logs user in
                    $this->_isLoggedIn = true;
                }
            }
        } else {
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
     * @desc                Method logs user in. If no name and password is provided...
     * @return              bool
     */
    public function loginUser($username = null, $password = null, $rememberUser = false)
    {
        if (!$username && !$password && !empty($this->_data)) {

            // Login using remember me cookie
            Session::add($this->_sessionName, $this->_data['u_id']);

        } else {

            // Default login functionality
            $user = $this->findUser($username);
            if ($user) {

                if ($this->_data['u_password'] === Hash::generateHash($password, $this->_data['u_salt'])) {

                    // Password matches and adds u_id to the session.
                    Session::add($this->_sessionName, $this->_data['u_id']);

                    if ($rememberUser) {

                        $hashCheck = $this->_database->select('user_session', ['user_id', '=', $this->_data['u_id']]);

                        if (!$hashCheck->getResultRowCount()) {

                            // Inserts cookie hash to the Database
                            $hash = Hash::generateFromUniqueId();
                            $this->_database->insert('user_session', [
                                'user_id' => $this->_data['u_id'],
                                'us_hash' => $hash
                            ]);

                        } else {

                            // Gets cookie has from the Database
                            $hash = $hashCheck->getResultFirstRecord()['us_hash'];

                        }
                        Cookie::add($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
                    }
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
        $this->_database->delete('user_session',['user_id','=',$this->_data['u_id']]);

        Session::delete($this->_sessionName);
        Cookie::delete($this->_cookieName);
    }

    /**
     * @method              checkIfRememberedUser
     * @desc                Method checks if hash exists in $_COOKIE super global and user is not logged in session.
     *                      It gets the hash from the cookie and compares it to the hash stored in the database.
     *                      If it matches it creates new instance of the user with 'user_id' and logs user in.
     */
    public static function checkIfRememberedUser()
    {
        if (Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {

            $hash = Cookie::get(Config::get('remember/cookie_name'));
            $hashCheck = Database::getInstance()->select('user_session', ['us_hash', '=', $hash]);

            if ($hashCheck->getResultRowCount()) {
                // Instantiates new User.
                $user = new User($hashCheck->getResultFirstRecord()['user_id']);
                $user->loginUser();
            }
        }
    }
}
<?php

class User
{
    // Database property
    private $_database;
    private $_data;
    private $_sessionName;
    private $_isLoggedIn;

    /**
     * User constructor.
     */
    public function __construct($user = null)
    {
        $this->_database = Database::getInstance();
        $this->_sessionName = Config::get('session/session_name');

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
    public function getData(){
        return $this->_data;
    }

    /**
     * @method              isLoggedIn
     * @desc                Getter for _isLoggedIn field.
     * @return              bool
     */
    public function isLoggedIn(){
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

    public function loginUser($username = null, $password = null)
    {
        $user = $this->findUser($username);

        if ($user) {
            if ($this->_data['u_password'] === Hash::generateHash($password, $this->_data['u_salt'])) {

                // Password matches and adds u_id to the session.
                Session::add($this->_sessionName, $this->_data['u_id']);
                return true;
            }
        }

        return false;
    }
}
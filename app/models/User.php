<?php

class User
{
    // Database property
    private $_database;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->_database = Database::getInstance();
    }

    public function createUser($userDetails){
        if(!$this->_database->insert('user',$userDetails)) {
            throw new Exception('There was a problem creating an account.');
        }
    }

}
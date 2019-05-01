<?php

class Membership
{
    private $_data = null;
    private $_database = null;

    public function __construct($userId)
    {
        $this->_database = Database::getInstance();

        $this->_data = $this->_database->select('membership',['u_id','=',$userId])->getResultFirstRecord();
    }

    public function getExpiryDate()
    {
        return $this->_data['me_expiry_date'];
    }

    public function checkIfValidMembership()
    {
        $expiryDate = $this->_data['me_expiry_date'];
        $today = date('Y-m-d');

        return ($expiryDate > $today) ? true : false;
    }
}
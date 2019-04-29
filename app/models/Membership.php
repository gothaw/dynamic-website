<?php

class Membership
{
    private $_data = null;
    private $_database = null;

    public function __construct($userId)
    {
        $this->_database = Database::getInstance();

        $this->_data = $this->_database->select('membership',['u_id','=',$userId])->getResultFirstRecord();

        trace($this->_data);
    }

    public function getUserMembershipDetails()
    {
        return $this->_data;
    }

    public function checkIfValidMembership()
    {
        $expiryDate = $this->_data['me_expiry_date'];
        return $expiryDate;
    }
}
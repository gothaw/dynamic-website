<?php

class Membership
{
    private $_data = null;
    private $_database = null;

    public function __construct($userId = null)
    {
        $this->_database = Database::getInstance();

        $result = $this->_database->select('membership', ['u_id', '=', $userId]);

        if ($result->getResultRowCount()) {
            $this->_data = $result->getResultFirstRecord();
        } else {
            $this->_data['me_expiry_date'] = null;
        }
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

    public function updateMembership($userId, $date)
    {
        if($this->_data['me_expiry_date'] === null){

            $this->_database->insert('membership', [
                'u_id' => $userId,
                'me_expiry_date' => $date
            ]);

        } else {
            $this->_database->update('membership','u_id',$userId,['me_expiry_date' => $date]);
        }
    }
}
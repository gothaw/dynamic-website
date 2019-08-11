<?php

/**
 *                              Class Membership
 * @desc                        Model for user membership. Allows for selecting membership info for given user id, checking if membership is valid, updating membership and canceling it.
 */
class Membership
{
    private $_data;
    private $_database;
    private $_userId;

    /**
     *                          Membership constructor.
     * @param                   $userId
     * @desc                    Gets user membership data if it exists in the `membership` table. If it does not exists it sets expiry date as null.
     */
    public function __construct($userId)
    {
        $this->_database = Database::getInstance();
        $this->_userId = $userId;

        $result = $this->_database->select('membership', ['u_id', '=', $userId]);

        if ($result->getResultRowCount()) {
            $this->_data = $result->getResultFirstRecord();
        } else {
            $this->_data['me_expiry_date'] = null;
        }
    }

    /**
     * @method                  getExpiryDate
     * @desc                    Gets expiry date from _data field.
     * @return                  string|null
     */
    public function getExpiryDate()
    {
        return $this->_data['me_expiry_date'];
    }

    /**
     * @method                  checkIfValidMembership
     * @desc                    Checks if expiry date is after today's date.
     * @return                  bool
     */
    public function checkIfValidMembership()
    {
        $expiryDate = $this->_data['me_expiry_date'];

        return ($expiryDate > date('Y-m-d')) ? true : false;
    }

    /**
     * @method                  updateMembership
     * @param                   $date {Year-month-day}
     * @desc                    If expiry date is set it updates user membership using given date.
     *                          Alternatively, it creates a new record in the `membership` table for given parameters.
     * @throws                  Exception
     */
    public function updateMembership($date)
    {
        if (isset($this->_data['me_expiry_date'])) {
            $isUpdated = $this->_database->update('membership', 'u_id', $this->_userId, ['me_expiry_date' => $date]);
        } else {
            $isUpdated = $this->_database->insert('membership', [
                'u_id' => $this->_userId,
                'me_expiry_date' => $date
            ]);
        }
        if (!$isUpdated) {
            throw new Exception("There was a problem updating membership.");
        }
    }

    /**
     * @method                  cancelMembership
     * @desc                    Deletes user membership from the database.
     * @throws                  Exception
     */
    public function cancelMembership()
    {
        $isDeleted = $this->_database->delete('membership', ['u_id', '=', $this->_userId]);
        if (!$isDeleted) {
            throw new Exception("There was a problem canceling membership.");
        }
    }
}
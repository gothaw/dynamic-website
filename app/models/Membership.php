<?php

class Membership
{
    private $_data;
    private $_database;

    /**
     *                          Membership constructor.
     * @param                   $userId
     * @desc                    Gets user membership data if it exists in the `membership` table. If it does not exists it sets expiry date as null.
     */
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
     * @param                   $userId
     * @param                   $date {Year-month-day}
     * @desc                    If expiry date is set it updates user membership using given date.
     *                          Alternatively, it creates a new record in the `membership` table for given parameters.
     */
    public function updateMembership($userId, $date)
    {
        if (isset($this->_data['me_expiry_date'])) {

            $this->_database->update('membership', 'u_id', $userId, ['me_expiry_date' => $date]);

        } else {

            $this->_database->insert('membership', [
                'u_id' => $userId,
                'me_expiry_date' => $date
            ]);
        }
    }

    /**
     * @method                  cancelMembership
     * @param                   $userId
     * @desc                    If expiry date in _data field is set it removes the record from `membership` for `u_id` equal to $userId.
     */
    public function cancelMembership($userId)
    {
        if (isset($this->_data['me_expiry_date'])) {

            $this->_database->delete('membership', ['u_id', '=', $userId]);

        }
    }
}
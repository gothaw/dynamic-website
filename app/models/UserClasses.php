<?php

class UserClasses
{
    private $_data;
    private $_database;
    private $_errors = [];
    private $_userId;

    /**
     *                      UserClasses constructor.
     * @param               $userId
     * @desc                Selects classes from `user_classes` table. Uses inner join on `schedule`, `class` and `coach` tables.
     */
    public function __construct($userId)
    {
        $this->_database = Database::getInstance();
        $this->_userId = $userId;

        $sql = "
                SELECT
                    `uc_id`,
                    `user_class`.`sc_id`,
                    `cl_name`,
                    `cl_duration`,
                    `cl_max_people`,
                    `sc_no_people`,
                    `sc_class_date`,
                    `sc_class_time`,
                    `co_first_name`,
                    `co_last_name`
                FROM 
                    `user_class`
                INNER JOIN `schedule`
                ON
                    `user_class`.`sc_id` = `schedule`.`sc_id`
                INNER JOIN `class`
                ON
                    `schedule`.`cl_id` = `class`.`cl_id`
                INNER JOIN `coach`
                ON
                    `schedule`.`co_id` = `coach`.`co_id`
                WHERE
                    `u_id` = ? AND `sc_class_date` >= CURDATE()
                ORDER BY
                    `schedule`.`sc_class_date`
                ASC
                ";

        $this->_data = $this->_database->query($sql, [(int)$userId])->getResult();
    }

    /**
     * @method              getData
     * @desc                Getter for _data field.
     * @return              array|null
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * @method              getClass
     * @param               $classId {`sc_id` column in `schedule` table}
     * @desc                Loops through $_data and returns class that has `sc_id` equal to $classId
     * @return              array|null
     */
    private function getClass($classId)
    {
        foreach ($this->_data as $class) {
            if ($class['sc_id'] === $classId) {
                return $class;
            }
        }
        return null;
    }

    /**
     * @method              getUserClassId
     * @param               $classId {'sc_id'}
     * @desc                Gets 'uc_id' for class with $classId in user classes.
     * @return              int|null
     */
    public function getUserClassId($classId)
    {
        $userClassId = $this->getClass($classId)['uc_id'];
        if (isset($userClassId)) {
            return $userClassId;
        } else {
            return null;
        }
    }

    /**
     * @method              checkIfSignedUp
     * @param               $classId
     * @desc                Checks if user already signed up to class with $classId.
     * @return              bool
     */
    public function checkIfSignedUp($classId)
    {
        if ($this->getClass($classId)) {
            $this->addError("You are already signed up for this class.");
            return true;
        }
        return false;
    }

    /**
     * @method              signUpUserToClass
     * @param               $classId {`sc_id` in `user_class` table}
     * @desc                Method signs up user to a class by inserting a new record to user class table with given $userId and $classId.
     * @throws              Exception
     */
    public function signUpUserToClass($classId)
    {
        $isSignedUp = $this->_database->insert('user_class', [
            'u_id' => $this->_userId,
            'sc_id' => $classId
        ]);

        if (!$isSignedUp) {
            throw new Exception("Could not sign up to the class. Sorry.");
        }
    }

    /**
     * @method              dropUserFromClass
     * @param               $userClassId {`uc_id` in `user_class` table}
     * @desc                Method removes user from a class by deleting relevant record.
     * @throws              Exception
     */
    public function dropUserFromClass($userClassId)
    {
        $isDeleted = $this->_database->delete('user_class', ['uc_id', '=', $userClassId]);

        if (!$isDeleted) {
            throw new Exception("Could not drop out from the class. Sorry.");
        }
    }

    /**
     * @method          deleteOldClasses
     * @desc            Method deletes all past user classes.
     */
    public function deleteOldClasses()
    {
        $sql = "
                DELETE 
                	`user_class`
                FROM 
                    `user_class`
                INNER JOIN `schedule`
                ON
                    `user_class`.`sc_id` = `schedule`.`sc_id`
                WHERE
                    `u_id` = ? AND `sc_class_date` < CURDATE()
                ";

        $this->_database->query($sql, [(int)$this->_userId])->getResult();
    }

    /**
     * @method               addError
     * @param                $error {string}
     * @desc                 Adds error message to the _errors array.
     */
    private function addError($error)
    {
        $this->_errors[] = $error;
    }

    /**
     * @method                  getFirstErrorMessage
     * @desc                    Gets first error message from error array.
     * @return                  string
     */
    public function getFirstErrorMessage()
    {
        return $this->_errors[0];
    }
}
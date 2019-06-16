<?php

class UserClasses
{
    private $_database;
    private $_classesData;
    private $_usersData;
    private $_errors = [];
    private $_userId;

    /**
     *                      UserClasses constructor.
     * @param               $userId
     * @desc                Selects classes from `user_classes` table.
     */
    public function __construct($userId = null)
    {
        $this->_database = Database::getInstance();
        if (isset($userId)) {
            $this->_userId = $userId;
        }
    }

    /**
     * @method              getClasses
     * @desc                Getter for _classesData field.
     * @return              array|null
     */
    public function getClassesData()
    {
        return $this->_classesData;
    }

    /**
     * @method              getClasses
     * @desc                Getter for _usersData field.
     * @return              array|null
     */
    public function getUsersData()
    {
        return $this->_usersData;
    }

    /**
     * @method              getClassFromData
     * @param               $scheduledId {`sc_id` column in `schedule` table}
     * @desc                Loops through $_classesData and returns class that has `sc_id` equal to $scheduledId
     * @return              array|null
     */
    private function getClassFromData($scheduledId)
    {
        foreach ($this->_classesData as $class) {
            if ($class['sc_id'] === $scheduledId) {
                return $class;
            }
        }
        return null;
    }

    /**
     * @method              getUserClassId
     * @param               $scheduledId {'sc_id'}
     * @desc                Gets 'uc_id' for class with $scheduledId in user classes.
     * @return              int|null
     */
    public function getUserClassId($scheduledId)
    {
        $userClassId = $this->getClassFromData($scheduledId)['uc_id'];
        if (isset($userClassId)) {
            return $userClassId;
        } else {
            return null;
        }
    }

    /**
     * @method              selectClasses
     * @param               $onlyFutureClasses {bool}
     * @desc                Selects user classes from the database. Uses inner join on `schedule`, `class` and `coach` tables.
     * @return              $this
     */
    public function selectClasses($onlyFutureClasses = true)
    {
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
                    `u_id` = ?
                ";

        if ($onlyFutureClasses) {
            $sql .= "  AND `sc_class_date` >= CURDATE()";
        }
        $sql .= " ORDER BY `schedule`.`sc_class_date` ASC";

        $this->_classesData = $this->_database->query($sql, [(int)$this->_userId])->getResult();

        return $this;
    }

    /**
     * @method                  selectUsers
     * @param                   $scheduledId
     * @desc                    Selects users that signed up to the scheduled class.
     * @return                  $this
     */
    public function selectUsers($scheduledId)
    {
        $sql = "
                SELECT
                    `user`.`u_id`,
                    `user`.`u_first_name`,
                    `user`.`u_last_name`,
                    `user`.`u_username`,
                    `user`.`u_email`
                FROM 
                    `user_class`
                INNER JOIN `schedule`
                ON
                    `user_class`.`sc_id` = `schedule`.`sc_id`
                INNER JOIN `user`
                ON 
                    `user_class`.`u_id` = `user`.`u_id`
                WHERE
                    `schedule`.`sc_id` = ?;
               ";

        $this->_usersData = $this->_database->query($sql, [(int)$scheduledId])->getResult();

        return $this;
    }


    /**
     * @method              checkIfSignedUp
     * @param               $scheduledId
     * @desc                Checks if user already signed up to class with $scheduledId.
     * @return              bool
     */
    public function checkIfSignedUp($scheduledId)
    {
        if ($this->getClassFromData($scheduledId)) {
            $this->addError("You are already signed up for this class.");
            return true;
        }
        return false;
    }

    /**
     * @method              signUpUserToClass
     * @param               $scheduledId {`sc_id` in `user_class` table}
     * @desc                Method signs up user to a class by inserting a new record to user class table with given $userId and $scheduledId.
     * @throws              Exception
     */
    public function signUpUserToClass($scheduledId)
    {
        $isSignedUp = $this->_database->insert('user_class', [
            'u_id' => $this->_userId,
            'sc_id' => $scheduledId
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
     * @method          deleteClassesForUserId
     * @desc            Method deletes all user classes for user with _userId.
     * @throws          Exception
     */
    public function deleteClassesForUserId()
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
                    `u_id` = ?";

        $isDeleted = $this->_database->query($sql, [(int)$this->_userId]);

        if (!$isDeleted) {
            throw new Exception("Could not delete user classes. Sorry.");
        }
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
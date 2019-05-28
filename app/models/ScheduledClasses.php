<?php

class ScheduledClasses
{
    private $_data;
    private $_database;
    private $_errors = [];

    /**
     *                      ScheduledClasses constructor.
     * @param               $numberOfClasses
     * @desc                Selects $numberOfClasses classes from `schedule` table.  Uses inner join on `class` and `coach` tables.
     *                      By default selects 7 classes.
     */
    public function __construct($numberOfClasses = null)
    {
        $this->_database = Database::getInstance();

        $sql = "
                SELECT 
                     `sc_id`,
                     `cl_name`,
                     `cl_duration`,
                     `cl_max_people`,
                     `sc_no_people`,
                     `sc_class_date`,
                     `sc_class_time`,
                     `co_first_name`,
                     `co_last_name`
                FROM 
                    `schedule` 
                    INNER JOIN `class`
                ON
                    `schedule`.`cl_id` = `class`.`cl_id`
                    INNER JOIN `coach`
                ON
                    `schedule`.`co_id` = `coach`.`co_id`
                WHERE
                    `sc_class_date` >= CURDATE()
                ORDER BY
                    `schedule`.`sc_class_date`
                ASC";

        if (isset($numberOfClasses)) {
            $sql .= " LIMIT ?;";
            $this->_data = $this->_database->query($sql, [(int)$numberOfClasses])->getResult();
        } else {
            $sql .= " LIMIT 7";
            $this->_data = $this->_database->query($sql)->getResult();
        }
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
     * @method                  addError
     * @param                   $error {string}
     * @desc                    Adds error message to the _errors array.
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

    /**
     * @method              getClass
     * @param               $scheduledId {`sc_id` column in `schedule` table}
     * @desc                Loops through $_data and returns class that has `sc_id` equal to $scheduledId
     * @return              array|null
     */
    private function getClass($scheduledId)
    {
        foreach ($this->_data as $class) {
            if ($class['sc_id'] === $scheduledId) {
                return $class;
            }
        }
        return null;
    }

    /**
     * @method              getClassName
     * @param               $scheduledId
     * @desc                Gets $scheduledId class name from _data field.
     * @return              string
     */
    public function getClassName($scheduledId)
    {
        $className = $this->getClass($scheduledId)['cl_name'];
        if (isset($className)) {
            return $className;
        } else {
            return '';
        }
    }

    /**
     * @method              checkIfPossibleToSignUp
     * @param               $membershipExpiryDate
     * @param               $scheduledId
     * @desc                Validates signing up to class shown in the schedule.
     * @return              bool
     */
    public function checkIfPossibleToSignUp($membershipExpiryDate, $scheduledId)
    {
        $selectedClass = $this->getClass($scheduledId);

        if (isset($selectedClass)) {

            if ($selectedClass['cl_max_people'] < $selectedClass['sc_no_people']) {

                $this->addError("Sorry this class is already fully booked. Please select different one.");

            } else if ($membershipExpiryDate < $selectedClass['sc_class_date']) {

                $this->addError("Please renew your membership before signing up to this class.");

            }
            if (empty($this->_errors)) {
                return true;
            }
        } else {

            $this->addError("Sorry, something went wrong. Pick a different class.");

        }
        return false;
    }

    /**
     * @method              addOnePersonToClass
     * @param               $scheduledId {`sc_id` column in `schedule` table}
     * @desc                Method adds 1 in `sc_no_people` field for record where `sc_id` is equal to $scheduledId.
     *                      Uses update method from Database object.
     * @throws              Exception
     */
    public function addOnePersonToClass($scheduledId)
    {
        $selectedClass = $this->getClass($scheduledId);

        $isUpdated = $this->_database->update('schedule', 'sc_id', $scheduledId, ['sc_no_people' => $selectedClass['sc_no_people'] + 1]);

        if (!$isUpdated) {
            throw new Exception("There was a problem signing up to the class.");
        }
    }

    /**
     * @method              removeOnePersonFromClass
     * @param               $scheduledId {`sc_id` column in `schedule` table}
     * @desc                Method removes 1 in `sc_no_people` field for record where `sc_id` is equal to $scheduledId.
     *                      Uses update method from Database object.
     * @throws              Exception
     */
    public function removeOnePersonFromClass($scheduledId)
    {
        $selectedClass = $this->getClass($scheduledId);

        $isUpdated = $this->_database->update('schedule', 'sc_id', $scheduledId, ['sc_no_people' => $selectedClass['sc_no_people'] - 1]);

        if (!$isUpdated) {
            throw new Exception("There was a problem dropping out from the class.");
        }
    }

    /**
     * @method                  deleteClassesByClassId
     * @param                   $classId
     * @desc                    Deletes scheduled classes by cl_id using two sql queries.
     * @throws                  Exception
     */
    public function deleteClassesByClassId($classId)
    {
        // Removing users from scheduled classes (nested query)
        $sql = "DELETE FROM `user_class` WHERE `sc_id` IN (SELECT `sc_id` FROM `schedule` WHERE `cl_id` = ?);";
        $isEachUserClassRemoved = $this->_database->query($sql, [(int)$classId]);
        // Removing scheduled classes
        $sql = "DELETE FROM `schedule` WHERE `cl_id` = ?";
        $isEachScheduledClassRemoved = $this->_database->query($sql, [(int)$classId]);

        if (!($isEachUserClassRemoved && $isEachScheduledClassRemoved)) {
            throw new Exception('There was problem deleting scheduled classes.');
        }
    }
}
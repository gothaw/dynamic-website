<?php

class ScheduledClasses
{
    private $_data;
    private $_database;
    private $_errors = [];
    private $_classesPerPage;
    private $_totalPages;

    /**
     *                      ScheduledClasses constructor.
     * @param               $classesPerPage
     * @desc                Sets database field.
     */
    public function __construct($classesPerPage = null)
    {
        $this->_classesPerPage = $classesPerPage;
        $this->_database = Database::getInstance();
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
     * @method              getPages
     * @desc                Getter for _totalPages field.
     * @return              int
     */
    public function getPages()
    {
        return $this->_totalPages;
    }

    /**
     * @method              setPages
     * @desc                Sets _pages field
     */
    public function setPages()
    {
        if(isset($this->_classesPerPage)){
            $sql = "SELECT COUNT(*) FROM `schedule`";
            $rowCount = $this->_database->query($sql)->getResultFirstRecord()['COUNT(*)'];
            $this->_totalPages = ceil($rowCount/$this->_classesPerPage);
        }
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
        return $className = $this->getClass($scheduledId)['cl_name'];
    }

    /**
     * @method              selectClasses
     * @param               $pageNumber {int}
     * @desc                Selects classes from `schedule` table. Selects classes with dates of today or after.
     *                      Uses inner join on `class` and `coach` tables. By default selects 7 classes.
     */
    public function selectClasses($pageNumber = null)
    {
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
                    LEFT JOIN `coach`
                ON
                    `schedule`.`co_id` = `coach`.`co_id`
                WHERE
                    `sc_class_date` >= CURDATE()
                ORDER BY
                    `schedule`.`sc_class_date`
                ASC";

        if (isset($this->_classesPerPage) && $pageNumber > 0) {

            // Gets number of classes equal to _classesPerPage but skips firsts $skipped classes
            $skipped = $this->_classesPerPage * $pageNumber - $this->_classesPerPage;
            $sql .= " LIMIT ?,?;";
            $this->_data = $this->_database->query($sql, [(int)$skipped, (int)$this->_classesPerPage])->getResult();

        } elseif (isset($this->_classesPerPage)) {

            // Gets number of classes equal to _classesPerPage
            $sql .= " LIMIT ?;";
            $this->_data = $this->_database->query($sql, [(int)$this->_classesPerPage])->getResult();

        } else {
            // Gets 7 classes
            $sql .= " LIMIT 7;";
            $this->_data = $this->_database->query($sql)->getResult();

        }
    }

    /**
     * @method              checkIfPossibleToSignUp
     * @param               $membershipExpiryDate
     * @param               $scheduledId
     * @desc                Validates signing up to class shown in the schedule. Requires setting _data field.
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
     *                      Uses update method from Database object. Requires setting _data field.
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
     *                      Uses update method from Database object. Requires setting _data field.
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
     * @desc                    Deletes scheduled classes by cl_id using two sql queries. Deletes rows from both 'schedule' and 'user_class' tables.
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
            throw new Exception("There was problem in deleting scheduled classes.");
        }
    }

    /**
     * @method                  deleteCoach
     * @param                   $coachId
     * @desc                    Deletes coach from scheduled classes by replacing co_id with null.
     * @throws                  Exception
     */
    public function deleteCoach($coachId)
    {
        $sql = "UPDATE `schedule` SET `co_id` = NULL WHERE co_id = ?;";
        if (!$this->_database->query($sql, [(int)$coachId])) {
            throw new Exception("There was a problem in deleting coach from scheduled classes.");
        }
    }
}
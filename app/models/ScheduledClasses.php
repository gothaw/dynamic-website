<?php

class ScheduledClasses
{
    private $_data;
    private $_database;
    private $_errors = [];
    private $_classesPerPage;
    private $_numberOfPages;

    /**
     *                          ScheduledClasses constructor.
     * @param                   $classesPerPage
     * @desc                    Sets database field.
     */
    public function __construct($classesPerPage = null)
    {
        $this->_classesPerPage = $classesPerPage;
        $this->_database = Database::getInstance();
    }

    /**
     * @method                  getData
     * @desc                    Getter for _data field.
     * @return                  array|null
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * @method                  getNumberOfPages
     * @desc                    Getter for _numberOfPages field.
     * @return                  int
     */
    public function getNumberOfPages()
    {
        return $this->_numberOfPages;
    }

    /**
     * @method                  setNumberOfPages
     * @desc                    Sets _numberOfPages field. Used in admin panel.
     */
    public function setNumberOfPages()
    {
        if (isset($this->_classesPerPage)) {
            $sql = "SELECT COUNT(*) FROM `schedule`";
            $rowCount = $this->_database->query($sql)->getResultFirstRecord()['COUNT(*)'];
            $this->_numberOfPages = ceil($rowCount / $this->_classesPerPage);
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
     * @method                  getClass
     * @param                   $scheduledId {`sc_id` column in `schedule` table}
     * @desc                    Loops through $_data and returns class that has `sc_id` equal to $scheduledId
     * @return                  array|null
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
     * @method                  getClassName
     * @param                   $scheduledId
     * @desc                    Gets $scheduledId class name from _data field.
     * @return                  string
     */
    public function getClassName($scheduledId)
    {
        return $className = $this->getClass($scheduledId)['cl_name'];
    }

    /**
     * @method                  selectClasses
     * @param                   $pageNumber {int}
     * @param                   $includePastClasses {bool}
     * @desc                    Selects classes from `schedule` table. By default selects 7 classes with dates of today or after.
     *                          Uses inner join on `class` and `coach` tables.
     * @return                  ScheduledClasses
     */
    public function selectClasses($pageNumber = null, $includePastClasses = false)
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
                ";

        // Statement to check if old classes are to be included
        if (!$includePastClasses) {
            $sql .= "WHERE `sc_class_date` >= CURDATE() ORDER BY `schedule`.`sc_class_date` ASC";
        } else {
            $sql .= "ORDER BY `schedule`.`sc_class_date` DESC";
        }

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
        return $this;
    }

    /**
     * @method                  selectClass
     * @param                   $scheduledId
     * @desc                    Selects class from the database for given scheduledId.
     * @return                  $this
     */
    public function selectClass($scheduledId)
    {
        if (is_numeric($scheduledId)) {
            $sql = "
                    SELECT *
                    FROM 
                        `schedule` 
                    INNER JOIN `class`
                    ON
                        `schedule`.`cl_id` = `class`.`cl_id`
                    LEFT JOIN `coach`
                    ON
                        `schedule`.`co_id` = `coach`.`co_id`
                    WHERE `schedule`.`sc_id` = ?;
                    ";

            $this->_data = $this->_database->query($sql, [(int)$scheduledId])->getResultFirstRecord();
        }
        return $this;
    }

    /**
     * @method                  checkIfValidClassTime
     * @param                   $newDate {Y-m-d}
     * @param                   $newStartTime {H:i}
     * @param                   $newDuration {class duration in minutes}
     * @param                   $scheduledId {scheduledId}
     * @desc                    Checks if class time and duration provided for a new scheduled class or class update are valid.
     *                          This is there is no time clash with other classes in the database.
     * @return                  bool
     */
    public function checkIfValidClassTime($newDate, $newStartTime, $newDuration, $scheduledId = null)
    {
        $newStartTime = substr($newStartTime, 0, 5);
        $newEndTime = date('H:i', strtotime($newStartTime) + $newDuration * 60);

        $sql = "
                SELECT * FROM 
                    `schedule` 
                INNER JOIN `class`
                ON
                    `schedule`.`cl_id` = `class`.`cl_id`
                WHERE `schedule`.`sc_class_date` = ?
               ";

        if (isset($scheduledId)) {
            $sql .= " AND `schedule`.`sc_id` != ?;";
            $classesOnSameDay = $this->_database->query($sql, [$newDate, (int)$scheduledId])->getResult();
        } else {
            $classesOnSameDay = $this->_database->query($sql, [$newDate])->getResult();
        }

        $classesTimes = [];

        foreach ($classesOnSameDay as $class) {
            $classesTimes [] = [
                'start' => substr($class['sc_class_time'], 0, 5),
                'end' => date('H:i', strtotime($class['sc_class_time']) + $class['cl_duration'] * 60)
            ];
        }

        foreach ($classesTimes as $time) {
            if ($newStartTime >= $time['start'] && $newStartTime < $time['end']) {
                $this->addError("Sorry this class clashes with other class on that day. Please select later time.");
                return false;
            } elseif ($newEndTime > $time['start'] && $newEndTime <= $time['end']) {
                $this->addError("Sorry this class clashes with other class on that day. Please select earlier time.");
                return false;
            } elseif ($newStartTime <= $time['start'] && $newEndTime >= $time['end']) {
                $this->addError("Sorry this class clashes with other class on that day. Please select different time.");
                return false;
            }
        }
        return true;
    }

    /**
     * @method                  validateClassTypeChange
     * @param                   $maxNumberOfPeople
     * @param                   $scheduledId
     * @desc                    Checks if a new class limit for number of people is not exceeded, when changing the class type.
     * @return                  bool
     */
    public function validateClassTypeChange($maxNumberOfPeople, $scheduledId)
    {
        if ($this->_data['sc_id'] === $scheduledId) {
            $selectedClass = $this->_data;
        } else {
            $selectedClass = $this->selectClass($scheduledId);
        }

        if ($selectedClass['sc_no_people'] > $maxNumberOfPeople) {
            $this->addError("Number of people that signed up to the class exceeds the class limit. Please select different class type.");
            return false;
        }
        return true;
    }

    /**
     * @method                  addScheduledClass
     * @param                   $fields {fields to be inserted to the database as an associative array}
     * @desc                    Adds new scheduled class to the database.
     * @throws                  Exception
     */
    public function addScheduledClass($fields = [])
    {
        if (!$this->_database->insert('schedule', $fields)) {
            throw new Exception('There was a problem in adding the scheduled class.');
        }
    }

    /**
     * @method                  updateScheduledClass
     * @param                   $scheduledId
     * @param                   $fields {fields to be inserted to the database as an associative array}
     * @desc                    Updates scheduled class in the database.
     * @throws                  Exception
     */
    public function updateScheduledClass($scheduledId, $fields = [])
    {
        if (!$this->_database->update('schedule', 'sc_id', $scheduledId, $fields)) {
            throw new Exception('There was a problem in updating the scheduled class.');
        }
    }

    /**
     * @method                  deleteScheduledClass
     * @param                   $scheduledId
     * @desc                    Deletes scheduled class from the database.
     * @throws                  Exception
     */
    public function deleteScheduledClass($scheduledId)
    {
        if (!$this->_database->delete('coach', ['co_id', '=', $scheduledId])) {
            throw new Exception('There was a problem deleting the scheduled class');
        }
    }


    /**
     * @method                  checkIfPossibleToSignUp
     * @param                   $membershipExpiryDate
     * @param                   $scheduledId
     * @desc                    Validates signing up to class shown in the schedule. Requires setting _data field.
     * @return                  bool
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
     * @method                  addOnePersonToClass
     * @param                   $scheduledId {`sc_id` column in `schedule` table}
     * @desc                    Method adds 1 in `sc_no_people` field for record where `sc_id` is equal to $scheduledId.
     *                          Uses update method from Database object. Requires setting _data field.
     * @throws                  Exception
     */
    public function addOnePersonToClass($scheduledId)
    {
        $selectedClass = $this->getClass($scheduledId);

        // Select class from the database if not in _data
        if (!isset($selectedClass)) {
            $selectedClass = $this->selectClass($scheduledId);
        }

        $isUpdated = $this->_database->update('schedule', 'sc_id', $scheduledId, ['sc_no_people' => $selectedClass['sc_no_people'] + 1]);

        if (!$isUpdated) {
            throw new Exception("There was a problem signing up to the class.");
        }
    }

    /**
     * @method                  removeOnePersonFromClass
     * @param                   $scheduledId {`sc_id` column in `schedule` table}
     * @desc                    Method removes 1 in `sc_no_people` field for record where `sc_id` is equal to $scheduledId.
     *                          Uses update method from Database object. Requires setting _data field.
     * @throws                  Exception
     */
    public function removeOnePersonFromClass($scheduledId)
    {
        $selectedClass = $this->getClass($scheduledId);

        // Select class from the database if not in _data
        if (!isset($selectedClass)) {
            $selectedClass = $this->selectClass($scheduledId);
        }

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
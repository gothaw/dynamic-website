<?php

class ScheduledClasses
{
    private $_data;
    private $_database;
    private $_errors = [];
    private $_numberOfPages;
    private $_currentPageNumber;

    /**
     *                          ScheduledClasses constructor.
     * @desc                    Sets database field.
     */
    public function __construct()
    {
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
     * @method                  getCurrentPageNumber
     * @desc                    Getter for _currentPageNumber field.
     * @return                  int
     */
    public function getCurrentPageNumber()
    {
        return $this->_currentPageNumber;
    }

    /**
     * @method                  setNumberOfPages
     * @param                   $classesPerPage
     * @desc                    Sets _numberOfPages field.
     */
    private function setNumberOfPages($classesPerPage)
    {
        $sql = "SELECT COUNT(*) FROM `schedule`";
        $rowCount = $this->_database->query($sql)->getResultFirstRecord()['COUNT(*)'];
        $this->_numberOfPages = ceil($rowCount / $classesPerPage);
    }

    /**
     * @method                  setSchedulePages
     * @param                   $classesPerPage {int}
     * @param                   $pageNumber {int}
     * @desc                    Sets total number of pages and current page fields.
     */
    private function setSchedulePages($classesPerPage, $pageNumber)
    {
        if (isset($classesPerPage) && isset($pageNumber)) {
            $this->setNumberOfPages($classesPerPage);
            if ($pageNumber < '1' || $pageNumber > $this->_numberOfPages || !is_numeric($pageNumber)) {
                $this->_currentPageNumber = '1';
            } else {
                $this->_currentPageNumber = $pageNumber;
            }
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
     * @method                  getClassFromData
     * @param                   $scheduledId {`sc_id` column in `schedule` table}
     * @desc                    If multidimensional array it loops through _data and returns class that has `sc_id` equal to $scheduledId.
     *                          Alternatively if only one class is in _data it invokes getData method.
     * @return                  array|null
     */
    private function getClassFromData($scheduledId)
    {
        if (isset($this->_data)) {
            if (isset($this->_data[0]) && is_array($this->_data[0])) {
                foreach ($this->_data as $class) {
                    if ($class['sc_id'] === $scheduledId) {
                        return $class;
                    }
                }
            } else {
                return $this->getData();
            }
        }
        return null;
    }

    /**
     * @method                  getClassName
     * @param                   $scheduledId
     * @desc                    Gets $scheduledId class name from _data field. Additionally, capitalizes every word.
     * @return                  string
     */
    public function getClassName($scheduledId)
    {
        return $className = ucwords($this->getClassFromData($scheduledId)['cl_name']);
    }

    /**
     * @method                  selectClasses
     * @param                   $onlyFutureClasses {bool}
     * @param                   $classesPerPage {int}
     * @param                   $pageNumber {int}
     * @desc                    Selects classes from `schedule` table. By default selects 7 classes with dates of today or after.
     *                          Uses inner join on `class` and `coach` tables.
     *                          Additionally, sets current page number of the schedule list and total number of pages.
     * @return                  ScheduledClasses
     */
    public function selectClasses($onlyFutureClasses = true, $classesPerPage = null, $pageNumber = null)
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
        if ($onlyFutureClasses) {
            $sql .= "WHERE `sc_class_date` > CURDATE() OR (`sc_class_date` = CURDATE() AND `schedule`.`sc_class_time` > CURTIME()) 
                    ORDER BY `schedule`.`sc_class_date` ASC";
        } else {
            $sql .= "ORDER BY `schedule`.`sc_class_date` DESC";
        }

        // Sets current page number and number of pages
        $this->setSchedulePages($classesPerPage, $pageNumber);

        if (isset($classesPerPage) && $this->_currentPageNumber > 0) {

            // Gets number of classes equal to _classesPerPage but skips firsts $skipped classes
            $skipped = $classesPerPage * $this->_currentPageNumber - $classesPerPage;
            $sql .= " LIMIT ?,?;";
            $this->_data = $this->_database->query($sql, [$skipped, $classesPerPage])->getResult();

        } elseif (isset($classesPerPage)) {

            // Gets number of classes equal to _classesPerPage
            $sql .= " LIMIT ?;";
            $this->_data = $this->_database->query($sql, [$classesPerPage])->getResult();

        } else {
            $this->_data = $this->_database->query($sql)->getResult();

        }
        return $this;
    }

    /**
     * @method                  selectClass
     * @param                   $scheduledId {int}
     * @param                   $onlyFutureClasses {bool}
     * @desc                    Selects class from the database for given scheduledId.
     * @return                  $this
     */
    public function selectClass($scheduledId, $onlyFutureClasses = true)
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
                    WHERE `schedule`.`sc_id` = ?
                    ";

            if ($onlyFutureClasses) {
                $sql .= " AND (`sc_class_date` > CURDATE() OR (`sc_class_date` = CURDATE() AND `schedule`.`sc_class_time` > CURTIME()))";
            }

            $this->_data = $this->_database->query($sql, [$scheduledId])->getResultFirstRecord();
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
            $classesOnSameDay = $this->_database->query($sql, [$newDate, $scheduledId])->getResult();
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
        $selectedClass = $this->getClassFromData($scheduledId);

        if (!isset($selectedClass)) {
            $this->addError("There was an error select different class.");
            return false;
        } elseif ($selectedClass['sc_no_people'] > $maxNumberOfPeople) {
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
     * @desc                    Deletes scheduled class from the database. Also removes all members from that class.
     * @throws                  Exception
     */
    public function deleteScheduledClass($scheduledId)
    {
        $isEveryUserRemovedFromClass = !$this->_database->delete('user_class', ['sc_id', '=', $scheduledId]);

        $isDeletedFromSchedule = !$this->_database->delete('schedule', ['sc_id', '=', $scheduledId]);

        if ($isEveryUserRemovedFromClass && $isDeletedFromSchedule) {
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
        $selectedClass = $this->getClassFromData($scheduledId);

        if (isset($selectedClass)) {

            if ($selectedClass['cl_max_people'] < $selectedClass['sc_no_people']) {

                $this->addError("Sorry this class is already fully booked. Please select different one.");

            } elseif ($membershipExpiryDate < $selectedClass['sc_class_date']) {

                $this->addError("Please renew membership before signing up to this class.");

            } elseif (date('Y-m-d') > $selectedClass['sc_class_date']) {

                $this->addError("You cannot sign up to the class that was in the past.");

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
        $selectedClass = $this->getClassFromData($scheduledId);

        if (isset($selectedClass)) {
            $isUpdated = !$this->_database->update('schedule', 'sc_id', $scheduledId, ['sc_no_people' => $selectedClass['sc_no_people'] + 1]);

            if ($isUpdated) {
                throw new Exception("There was a problem signing up to the class.");
            }
        }
    }

    /**
     * @method                  removeOnePersonFromClass
     * @param                   $scheduledId {`sc_id` column in `schedule` table}
     * @desc                    Method removes 1 in `sc_no_people` field for record where `sc_id` is equal to $scheduledId.
     *                          Uses update method from Database object. Requires setting _data.
     * @throws                  Exception
     */
    public function removeOnePersonFromClass($scheduledId)
    {
        $selectedClass = $this->getClassFromData($scheduledId);

        if (isset($selectedClass)) {
            $isUpdated = !$this->_database->update('schedule', 'sc_id', $scheduledId, ['sc_no_people' => $selectedClass['sc_no_people'] - 1]);

            if ($isUpdated) {
                throw new Exception("There was a problem dropping out from the class.");
            }
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
        $isEachUserClassRemoved = !$this->_database->query($sql, [(int)$classId]);
        // Removing scheduled classes
        $sql = "DELETE FROM `schedule` WHERE `cl_id` = ?";
        $isEachScheduledClassRemoved = !$this->_database->query($sql, [(int)$classId]);

        if ($isEachUserClassRemoved && $isEachScheduledClassRemoved) {
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
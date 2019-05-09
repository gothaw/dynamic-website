<?php

class UpcomingClasses
{
    private $_data;
    private $_database;

    /**
     *                      UpcomingClasses constructor.
     * @param               $numberOfClasses
     * @desc                Selects $numberOfClasses classes from `schedule` table.  Uses inner join on `class` and `coach` tables.
     */
    public function __construct($numberOfClasses)
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
                    `sc_class_date` > CURRENT_TIMESTAMP
                ORDER BY
                    `schedule`.`sc_class_date`
                ASC
                LIMIT ?;
                ";

        $this->_data = $this->_database->query($sql, [(int)$numberOfClasses])->getResult();
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
     * @method              findClass
     * @param               $classId {`sc_id` column in `schedule` table}
     * @desc                Loops through $_data and returns class that has `sc_id` equal to $classId
     * @return              array|null
     */
    public function findClass($classId)
    {
        foreach ($this->_data as $class) {
            if ($class['sc_id'] === $classId) {
                return $class;
            }
        }
        return null;
    }

    /**
     * @method              addOnePerson
     * @param               $classId {`sc_id` column in `schedule` table}
     * @desc                Method adds 1 in `sc_no_people` field for record where `sc_id` is equal to $classId.
     *                      Uses update method from Database object.
     */
    public function addOnePerson($classId)
    {
        $selectedClass = $this->findClass($classId);

        $this->_database->update('schedule', 'sc_id', $classId, ['sc_no_people' => $selectedClass['sc_no_people'] + 1]);
    }

    /**
     * @method              removeOnePerson
     * @param               $classId {`sc_id` column in `schedule` table}
     * @desc                Method removes 1 in `sc_no_people` field for record where `sc_id` is equal to $classId.
     *                      Uses update method from Database object.
     */
    public function removeOnePerson($classId)
    {
        $selectedClass = $this->findClass($classId);

        $this->_database->update('schedule', 'sc_id', $classId, ['sc_no_people' => $selectedClass['sc_no_people'] - 1]);
    }
}
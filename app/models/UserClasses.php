<?php

class UserClasses
{
    private $_data = null;
    private $_database = null;

    /**
     *                      UserClasses constructor.
     * @param               $userId
     * @desc                Selects classes from `user_classes` table. Uses inner join on `schedule`, `class` and `coach` tables.
     */
    public function __construct($userId)
    {
        $this->_database = Database::getInstance();

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
                    `u_id` = ? AND `sc_class_date` > CURRENT_TIMESTAMP
                ORDER BY
                    `schedule`.`sc_class_date`
                ASC
                ";

        $this->_data = $this->_database->query($sql, [(int)$userId])->getResult();
    }

    /**
     * @method              getClassesDetails
     * @desc                Getter for _data field.
     * @return              array|null
     */
    public function getClassesDetails()
    {
        return $this->_data;
    }

    /**
     * @method              selectClass
     * @param               $classId {`sc_id` column in `schedule` table}
     * @desc                Loops through $_data and returns class that has `sc_id` equal to $classId
     * @return              array|null
     */
    public function selectClass($classId)
    {
        foreach ($this->_data as $class) {
            if ($class['sc_id'] === $classId) {
                return $class;
            }
        }
        return null;
    }

    /**
     * @method              signUpUserToClass
     * @param               $userId {`u_id` in `user_class` table}
     * @param               $classId {`sc_id` in `user_class` table}
     * @desc                Method signs up user to a class by inserting a new record to user class table with given $userId and $classId.
     */
    public function signUpUserToClass($userId, $classId)
    {
        $this->_database->insert('user_class', [
            'u_id' => $userId,
            'sc_id' => $classId
        ]);
    }

    /**
     * @method              dropUserFromClass
     * @param               $userClassId {`uc_id` in `user_class` table}
     * @desc                Method removes user from a class by deleting relevant record.
     */
    public function dropUserFromClass($userClassId)
    {
        $this->_database->delete('user_class', ['uc_id', '=', $userClassId]);
    }
}
<?php

class UpcomingClasses
{
    private $_data = null;

    private function loadData($numberOfClasses)
    {
        $database = Database::getInstance();
        $sql = "
                SELECT 
                     `sc_id`,
                     `cl_name`,
                     `cl_duration`,
                     `cl_max_people`,
                     `sc_no_people`,
                     `sc_class_date`,
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
        $this->_data = $database->query($sql,[(int)$numberOfClasses])->getResult();
    }

    public function getClasses($numberOfClasses){
        $this->loadData($numberOfClasses);
        return $this->_data;
    }

}
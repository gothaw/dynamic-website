<?php

class Classes
{
    private $_data = null;

    public function __construct($numberOfClasses)
    {
        $database = Database::getInstance();

        $sql = "
                SELECT 
                    `cl_name`,
                    `cl_desc`,
                    `cl_img_url`,
                    `cl_img_alt`
                FROM 
                    `class` INNER JOIN `class_image`
                ON
                    `class`.`cl_img_id` = `class_image`.`cl_img_id`
                ORDER BY 
                    `cl_id`
                ASC";
        if (isset($numberOfClasses)) {

            $sql .= " LIMIT ?;";
            $this->_data = $database->query($sql, [(int)$numberOfClasses])->getResult();

        } else {

            $this->_data = $database->query($sql)->getResult();
        }
    }

    public function getClassesDetails()
    {
        return $this->_data;
    }
}
<?php

class Classes
{
    private $_data;
    private $_database;

    /**
     *                      Classes constructor.
     * @desc                Sets database field.
     */
    public function __construct()
    {
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
     * @method              selectClasses
     * @param               $numberOfClasses
     * @desc                Selects classes details from `class` table. Uses inner join with `class_image` table.
     */
    public function selectClasses($numberOfClasses = null)
    {
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
                DESC
                ";

        if (isset($numberOfClasses)) {
            $sql .= " LIMIT ?;";
            $this->_data = $this->_database->query($sql, [(int)$numberOfClasses])->getResult();
        } else {
            $this->_data = $this->_database->query($sql)->getResult();
        }
    }
}
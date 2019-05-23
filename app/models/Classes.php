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
                    *
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

    /**
     * @method              getClass
     * @param               $classId
     * @desc                Loops through _data and gets class with id of $classId
     * @return              array|null
     */
    public function getClass($classId)
    {
        if (isset($this->_data)) {
            foreach ($this->_data as $class) {
                if ($class['cl_id'] === $classId) {
                    return $class;
                }
            }
        }
        return null;
    }

    /**
     * @method              updateClass
     * @param               $classId
     * @param               $fields {fields to be inserted to the database as an associative array}
     * @desc                Updates class details in 'class' table in the database.
     * @throws              Exception
     */
    public function updateClass($classId, $fields = [])
    {
        if (!$this->_database->update('class', 'cl_id', $classId, $fields)) {
            throw new Exception('There was a problem updating the class.');
        }
    }

    /**
     * @method              updateClassImageDetails
     * @param               $classId
     * @param               $fields {fields to be inserted to the database as an associative array}
     * @desc                Updates class details in 'class_image' table in the database
     * @throws              Exception
     */
    public function updateClassImageDetails($classId, $fields = [])
    {
        $classImageId = $this->getClass($classId)['cl_img_id'];
        if (!$this->_database->update('class_image', 'cl_img_id', $classImageId, $fields)) {
            throw new Exception('There was a problem updating the class image.');
        }
    }
}
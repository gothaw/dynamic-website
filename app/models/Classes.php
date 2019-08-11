<?php

/**
 *                          Class Classes
 * @desc                    Model for class types and class types images. Allows for selecting, adding, editing and deleting data in `class` and `class_image` tables.
 */
class Classes
{
    private $_data;
    private $_database;
    private $_imagePath;

    /**
     *                      Classes constructor.
     * @desc                Sets database field. Sets class image path in dist folder.
     */
    public function __construct()
    {
        $this->_database = Database::getInstance();
        $this->_imagePath = 'img/classes';
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
     * @method              getImagePath
     * @desc                Gets class image path in dist folder.
     * @return              string
     */
    public function getImagePath()
    {
        return $this->_imagePath;
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
     * @method              selectClasses
     * @param               $numberOfClasses
     * @desc                Selects classes details from `class` table. Uses inner join with `class_image` table.
     * @return              Classes
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
            $this->_data = $this->_database->query($sql, [$numberOfClasses])->getResult();
        } else {
            $this->_data = $this->_database->query($sql)->getResult();
        }
        return $this;
    }

    /**
     * @method              findClassImageId
     * @param               $url
     * @desc                Finds class image id in the database for given image url.
     * @return              int|null
     */
    public function findClassImageId($url)
    {
        $class = $this->_database->select('class_image', ['cl_img_url', '=', $url])->getResultFirstRecord();
        if (isset($class)) {
            return $class['cl_img_id'];
        } else {
            return null;
        }
    }

    /**
     * @method              addClass
     * @param               $fields {fields to be inserted to the database as an associative array}
     * @desc                Inserts details for a new class to the database.
     * @throws              Exception
     */
    public function addClass($fields = [])
    {
        if (!$this->_database->insert('class', $fields)) {
            throw new Exception('There was a problem in adding the class.');
        }
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
            throw new Exception('There was a problem in updating the class.');
        }
    }

    /**
     * @method              deleteClass
     * @param               $classId
     * @desc                Deletes class details from the database.
     * @throws              Exception
     */
    public function deleteClass($classId)
    {
        if (!$this->_database->delete('class', ['cl_id', '=', $classId])) {
            throw new Exception('There was problem in deleting the class');
        }
    }

    /**
     * @method              addClassImageDetails
     * @param               $fields {fields to be inserted to the database as an associative array}
     * @desc                Inserts class image details in the database.
     * @throws              Exception
     */
    public function addClassImageDetails($fields = [])
    {
        if (!$this->_database->insert('class_image', $fields)) {
            throw new Exception('There was a problem in adding the class image.');
        }
    }

    /**
     * @method              updateClassImageDetails
     * @param               $classId
     * @param               $fields {fields to be inserted to the database as an associative array}
     * @desc                Updates class image details in the database.
     * @throws              Exception
     */
    public function updateClassImageDetails($classId, $fields = [])
    {
        $classImageId = $this->getClass($classId)['cl_img_id'];
        if (!$this->_database->update('class_image', 'cl_img_id', $classImageId, $fields)) {
            throw new Exception('There was a problem in updating the class image.');
        }
    }

    /**
     * @method              deleteClassImageDetails
     * @param               $classId
     * @desc                Deletes class image details from the database.
     * @throws              Exception
     */
    public function deleteClassImageDetails($classId)
    {
        $classImageId = $this->getClass($classId)['cl_img_id'];
        if (!$this->_database->delete('class_image', ['cl_img_id', '=', $classImageId])) {
            throw new Exception('There was a problem in deleting class image');
        }
    }
}
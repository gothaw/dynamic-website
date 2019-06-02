<?php

class Coaches
{
    private $_data;
    private $_database;

    /**
     *                      Coaches constructor.
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
     * @method              getImageLocation
     * @param               $coachId
     * @desc                Gets class image location in dist folder. By default: 'img/classes'.
     * @return              string
     */
    public function getImageLocation($coachId = null)
    {
        if (isset($coachId)) {
            $imageUrlArray = explode('/', $this->getCoach($coachId)['co_img']);
            return implode('/', array_splice($imageUrlArray, 0, -1));
        } else {
            return 'img/coaches';
        }
    }

    /**
     * @method              getCoach
     * @param               $coachId
     * @desc                Loops through _data and gets coach with id of $classId
     * @return              array|null
     */
    public function getCoach($coachId)
    {
        if (isset($this->_data)) {
            foreach ($this->_data as $coach) {
                if ($coach['co_id'] === $coachId) {
                    return $coach;
                }
            }
        }
        return null;
    }

    /**
     * @method              selectCoaches
     * @desc                Selects coaches details from the database.
     */
    public function selectCoaches()
    {
        $sql = "SELECT * FROM `coach` ORDER BY `co_id` ASC;";

        $this->_data = $this->_database->query($sql)->getResult();
    }

    /**
     * @method              addCoach
     * @param               $fields {fields to be inserted to the database as an associative array}
     * @desc                Inserts new coach into the database.
     * @throws              Exception
     */
    public function addCoach($fields = [])
    {
        if (!$this->_database->insert('coach', $fields)) {
            throw new Exception('There was a problem in adding new coach.');
        }
    }

    /**
     * @method              updateCoach
     * @param               $coachId
     * @param               $fields {fields to be inserted to the database as an associative array}
     * @desc                Updates coach details in the database.
     * @throws              Exception
     */
    public function updateCoach($coachId, $fields = [])
    {
        if (!$this->_database->update('coach', 'co_id', $coachId, $fields)) {
            throw new Exception('There was a problem in updating the coach details.');
        }
    }

    /**
     * @method              deleteCoach
     * @param               $coachId
     * @desc                Deletes coach from the database.
     * @throws              Exception
     */
    public function deleteCoach($coachId)
    {
        if (!$this->_database->delete('coach', ['co_id', '=', $coachId])) {
            throw new Exception('There was a problem deleting the coach');
        }
    }
}
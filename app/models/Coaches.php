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
}
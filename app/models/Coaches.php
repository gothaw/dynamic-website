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
     * @method              selectCoaches
     * @desc                Selects coaches details from the database.
     */
    public function selectCoaches()
    {
        $sql = "
                SELECT 
                    `co_first_name`,
                    `co_last_name`,
                    `co_focus`,
                    `co_img`,
                    `co_facebook`,
                    `co_twitter`,
                    `co_linkedin`
                FROM `coach`
                ORDER BY
                    `co_id`
                ASC;
                ";

        $this->_data = $this->_database->query($sql)->getResult();
    }
}
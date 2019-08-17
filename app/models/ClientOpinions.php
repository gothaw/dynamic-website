<?php

/**
 *                          Class ClientOpinions
 * @desc                    Model for client opinions shown on home page slider.
 */
class ClientOpinions
{
    private $_data;
    private $_database;

    /**
     *                      ClientOpinions constructor.
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
     * @method              selectOpinions
     * @param               $numberOfOpinions
     * @desc                Selects client opinions from the database.
     * @return              ClientOpinions
     */
    public function selectOpinions($numberOfOpinions)
    {
        $sql = "
                SELECT
                    `op_id`,
                    `op_client_name`,
                    `op_photo_url`,
                    `op_desc`,
                    `cl_name`
                FROM
                  `opinion` LEFT JOIN `class`
                ON
                  `opinion`.`cl_id` = `class`.`cl_id`
                ORDER BY `op_id`
                DESC
                LIMIT ?;
                ";

        $this->_data = $this->_database->query($sql,[$numberOfOpinions])->getResult();

        return $this;
    }

}
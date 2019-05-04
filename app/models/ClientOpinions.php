<?php

class ClientOpinions
{
    private $_data = null;

    /**
     *                      ClientOpinions constructor.
     * @param               $numberOfOpinions {int}
     * @desc                Selects client opinions from the database.
     */
    public function __construct($numberOfOpinions)
    {
        $database = Database::getInstance();
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
        $this->_data = $database->query($sql,[(int)$numberOfOpinions])->getResult();
    }

    /**
     * @method              getClientOpinions
     * @desc                Getter for _data field.
     * @return              array|null
     */
    public function getClientOpinions()
    {
        return $this->_data;
    }

}
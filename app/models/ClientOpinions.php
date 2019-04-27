<?php

class ClientOpinions
{
    private $_data = null;

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

    public function getClientOpinions()
    {
        return $this->_data;
    }

}
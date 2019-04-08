<?php

class ClientOpinions
{
    private $_data = null;

    private function loadData($numberOfOpinions)
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

    public function getClientOpinions($numberOfOpinions)
    {
        $this->loadData($numberOfOpinions);
        return $this->_data;
    }

}
<?php

class ClientOpinions {

    private $_data;

    private function loadData() {
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
                LIMIT 6;
                ";
        $this->_data = $database->query($sql)->getResult();
    }

    public function getClientOpinions(){
        $this->loadData();
        return $this->_data;
    }

}
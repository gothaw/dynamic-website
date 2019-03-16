<?php

class ClientOpinions extends Database
{
    private $_data;

    private function loadData() {
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
        $mysqli = $this->connectToDatabase();
        $result = $mysqli->query($sql);
        $numRows = $result->num_rows;
        if($numRows > 0){
            $opinions = [];
            while($row = $result->fetch_assoc()){
                array_push($opinions,$row);
            }
            $this->_data = $opinions;
        }
    }

    public function getClientOpinions(){
        $this->loadData();
        return $this->_data;
    }

}
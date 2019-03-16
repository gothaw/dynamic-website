<?php

class Coaches extends Database {

    private $_data;

    private function loadData() {
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
        $mysqli = $this->connectToDatabase();
        $result = $mysqli->query($sql);
        $numRows = $result->num_rows;
        if($numRows > 0){
            $coaches = [];
            while($row = $result->fetch_assoc()){
                array_push($coaches,$row);
            }
            $this->_data = $coaches;
        }
    }

    public function getCoachesDetails(){
        $this->loadData();
        return $this->_data;
    }
}
<?php

class CurrentPage extends Database {

    private $_data;

    private function loadData($pageName) {
        $sql = "
                SELECT
                    *
                FROM
                    `page`
                WHERE
                    `page`.`pg_name` = '$pageName';
               ";
        $mysqli = $this->connectToDatabase();
        $result = $mysqli->query($sql);
        $numRows = $result->num_rows;
        if($numRows > 0){
            $data = $result->fetch_assoc();
            $this->_data = $data;
        }
    }

    public function getPageDetails($pageName){
        $this->loadData($pageName);
        return $this->_data;
    }
}
<?php

class CurrentPage extends Database {

    private $data;

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
            $this->data = $data;
        }
    }

    public function getPageDetails($pageName){
        $this->loadData($pageName);
        return $this->data;
    }
}
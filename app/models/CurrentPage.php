<?php
class CurrentPage extends Database {

    private $data;

    private function loadData($page_name) {
        $sql = "
                SELECT
                    *
                FROM
                    `page`
                WHERE
                    `page`.`pgName` = '$page_name';
               ";
        $mysqli = $this->connectToDatabase();
        $result = $mysqli->query($sql);
        $num_rows = $result->num_rows;
        if($num_rows > 0){
            $data = $result->fetch_assoc();
            $this->data = $data;
        }
    }

    public function getPageDetails($page_name){
        $this->loadData($page_name);
        return $this->data;
    }
}
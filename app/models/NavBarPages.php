<?php

class NavBarPages extends Database {

    private $data;

    private function loadData() {
        $sql = "
                SELECT
                    `page`.`pg_name`,
                    `page`.`pg_url`
                FROM
                    `page`
                ORDER BY
                    `page`.`pg_order`
                ASC";
        $mysqli = $this->connectToDatabase();
        $result = $mysqli->query($sql);
        $numRows = $result->num_rows;
        if($numRows > 0){
            $pages = [];
            while($row = $result->fetch_assoc()){
                array_push($pages,$row);
            }
            $this->data = $pages;
        }
    }

    public function getNavBarPages(){
        $this->loadData();
        return $this->data;
    }
}
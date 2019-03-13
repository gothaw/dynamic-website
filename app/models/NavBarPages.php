<?php
class NavBarPages extends Database {

    private $data;

    private function loadData() {
        $sql = "
                SELECT
                    `page`.`pgName`,
                    `page`.`pgUrl`
                FROM
                    `page`
                ORDER BY
                    `page`.`pgOrder`
                ASC";
        $mysqli = $this->connectToDatabase();
        $result = $mysqli->query($sql);
        $num_rows = $result->num_rows;
        if($num_rows > 0){
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
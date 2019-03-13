<?php
class Page extends Database {

    private $data;

    private function loadData($page_name) {
        $sql = "
                SELECT
                    *
                FROM
                    `page`
                WHERE
                    `page`.`pgName` = ?;
               ";
        $result = $this->connect()->query($sql);
        $numRows = $result->num_rows;
        if($numRows > 0){
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
            $this->data = $data;
        }
    }

    public function getAllPages(){
        $this->loadData();
        return $this->data;
    }
}
<?php
class Page extends Database {

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
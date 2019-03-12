<?php
class Page extends Database {

    public function getAllPages() {
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
            return $data;
        }
    }
}
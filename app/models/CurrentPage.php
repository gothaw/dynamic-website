<?php

class CurrentPage{

    private $_data;

    private function loadData($pageName) {
        $database = Database::getInstance();
        $sql = "
                SELECT
                    *
                FROM
                    `page`
                WHERE
                    `page`.`pg_name` = ?;
               ";
        $this->_data = $database->query($sql,[$pageName])->getResult();
    }

    public function getPageDetails($pageName){
        $this->loadData($pageName);
        return $this->_data;
    }
}
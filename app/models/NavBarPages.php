<?php

class NavBarPages
{
    private $_data = null;

    private function loadData()
    {
        $database = Database::getInstance();
        $sql = "
                SELECT
                    `page`.`pg_name`,
                    `page`.`pg_url`
                FROM
                    `page`
                WHERE
                    `pg_order` < 100
                ORDER BY
                    `page`.`pg_order`
                ASC;
                ";
        $this->_data = $database->query($sql)->getResult();
    }

    public function getNavBarPages()
    {
        $this->loadData();
        return $this->_data;
    }
}
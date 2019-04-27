<?php

class NavBarPages
{
    private $_data = null;

    public function __construct()
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
        return $this->_data;
    }
}
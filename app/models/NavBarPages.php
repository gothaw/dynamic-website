<?php

class NavBarPages
{
    private $_data;

    /**
     *                      NavBarPages constructor.
     * @desc                Selects page names and urls to generate the navigation bar in views.
     */
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

    /**
     * @method              getNavBarPages
     * @desc                Getter for _data field.
     * @return              array|null
     */
    public function getNavBarPages()
    {
        return $this->_data;
    }
}
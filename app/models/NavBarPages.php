<?php

/**
 *                          Class NavBarPages
 * @desc                    Model for navigation bar data. Allows for selecting url data and names for navigation bar from `page` table.
 */
class NavBarPages
{
    private $_data;
    private $_database;

    /**
     *                      NavBarPages constructor.
     * @desc                Selects page names and urls to generate the navigation bar in views.
     */
    public function __construct()
    {
        $this->_database = Database::getInstance();
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
        $this->_data = $this->_database->query($sql)->getResult();
    }

    /**
     * @method              getData
     * @desc                Getter for _data field.
     * @return              array|null
     */
    public function getData()
    {
        return $this->_data;
    }
}
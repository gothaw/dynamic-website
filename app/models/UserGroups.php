<?php

/**
 *                          Class UserGroups
 * @desc                    Model for user permission groups. Allows for selecting user permissions in `user_group` table.
 */
class UserGroups
{
    private $_data;
    private $_database;

    /**
     *                      UserGroups constructor.
     * @desc                Selects all user permissions from `user_group` table.
     */
    public function __construct()
    {
        $this->_database = Database::getInstance();

        $sql = "SELECT * FROM `user_group` ORDER BY `u_group_id` ASC;";

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
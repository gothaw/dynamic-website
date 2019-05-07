<?php

class UserGroups
{
    private $_data;

    /**
     *                      UserGroups constructor.
     * @desc                Selects all user permissions from `user_group` table.
     */
    public function __construct()
    {
        $database = Database::getInstance();

        $sql = "SELECT * FROM `user_group` ORDER BY `u_group_id` ASC";

        $this->_data = $database->query($sql)->getResult();
    }

    public function getUserGroupsDetails()
    {
        return $this->_data;
    }
}
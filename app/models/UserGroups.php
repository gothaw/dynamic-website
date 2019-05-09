<?php

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

    /**
     * @method              getIdForGroupName
     * @param               $groupName
     * @desc                Gets group id based on name. If not found, returns group id for which permissions are null i.e. standard user.
     * @return              int|null
     */
    public function getIdForGroupName($groupName)
    {
        foreach ($this->_data as $group){
            if($group['u_group_name'] === $groupName){
                return $group['u_group_id'];
            }
        }

        foreach ($this->_data as $group){
            if(!(isset($group['u_permissions']))){
                return $group['u_group_id'];
            }
        }

        return null;
    }
}
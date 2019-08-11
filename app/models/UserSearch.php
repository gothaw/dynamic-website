<?php

/**
 *                          Class UserSearch
 *                          Model for user search in admin panel. Used in admin panel members and membership area.
 *                          Allows for getting data from `user` and `membership` tables based on search results.
 */
class UserSearch
{
    private $_data;
    private $_database;

    /**
     *                      UserSearch constructor.
     * @param               $key
     * @desc                Searches user table for users, which id, username or last name contain $key.
     */
    public function __construct($key)
    {
        $this->_database = Database::getInstance();

        $sql = "SELECT 
                    `user`.*,
                    `membership`.`me_expiry_date`
                FROM
                    `user`
                LEFT JOIN
                    `membership`
                ON
                	`user`.`u_id` = `membership`.`u_id`
                WHERE
                    `user`.`u_id` LIKE ?
                OR    
                    `u_username` LIKE ?
                OR
                    `u_last_name` LIKE ?
                ORDER BY 
                    `user`.`u_id`
                ASC
                ";

        $this->_data = $this->_database->query($sql, ['%' . $key . '%', '%' . $key . '%', '%' . $key . '%'])->getResult();
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
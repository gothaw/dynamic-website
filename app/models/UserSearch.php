<?php

class UserSearch
{
    private $_data;
    private $_membeshipData;
    private $_database;

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

    public function getUserData()
    {
        return $this->_data;
    }
}
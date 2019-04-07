<?php

class Coaches
{
    private $_data = null;

    private function loadData()
    {
        $database = Database::getInstance();
        $sql = "
                SELECT 
                    `co_first_name`,
                    `co_last_name`,
                    `co_focus`,
                    `co_img`,
                    `co_facebook`,
                    `co_twitter`,
                    `co_linkedin`
                FROM `coach`
                ORDER BY
                    `co_id`
                ASC;
                ";
        $this->_data = $database->query($sql)->getResult();
    }

    public function getCoachesDetails()
    {
        $this->loadData();
        return $this->_data;
    }
}
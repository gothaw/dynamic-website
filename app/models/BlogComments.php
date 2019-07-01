<?php

class BlogComments
{
    private $_data;
    private $_database;

    /**
     *                          BlogComments constructor.
     * @desc                    Sets database field.
     */
    public function __construct()
    {
        $this->_database = Database::getInstance();
    }

    /**
     * @method                  getData
     * @desc                    Getter for _data field.
     * @return                  array|null
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * @method                  selectComments
     * @param                   $postId
     * @desc                    Selects comments from the database for selected post.
     * @return                  $this
     */
    public function selectComments($postId)
    {
        $sql = "SELECT
                    * 
                FROM 
                    `post_comment` 
                WHERE
                    `p_id` = ?
                ORDER BY
                    `pc_date` ASC,
                    `pc_time` ASC;
               ";

        $this->_data = $this->_database->query($sql, [$postId])->getResult();

        return $this;
    }

}
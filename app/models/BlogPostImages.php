<?php

class BlogPostImages
{
    private $_data;
    private $_database;

    /**
     *                          BlogPostImages constructor.
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
     * @method                  selectPostImages
     * @desc                    Select all images details from post_img table.
     * @return                  $this
     */
    public function selectPostImages()
    {
        $sql = "SELECT * FROM `post_img`";

        $this->_data = $this->_database->query($sql)->getResult();

        return $this;
    }
}
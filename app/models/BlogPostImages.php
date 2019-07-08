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

    public function selectClassImages()
    {
        $sql = "SELECT * FROM `post_image`";


    }
}
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
    public function selectImages()
    {
        $sql = "SELECT * FROM `post_img`";

        $this->_data = $this->_database->query($sql)->getResult();

        return $this;
    }

    /**
     * @method                  selectImage
     * @param                   $postImageId
     * @desc                    Selects image from the database for given p_img_id.
     * @return                  $this
     */
    public function selectImage($postImageId)
    {
        $this->_data = $this->_database->select('post_img', ['p_img_id', '=', $postImageId])->getResultFirstRecord();

        return $this;
    }
}
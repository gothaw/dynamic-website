<?php

class BlogPostImages
{
    private $_data;
    private $_database;
    private $_defaultImageData;

    /**
     *                          BlogPostImages constructor.
     * @desc                    Sets database field and default image field.
     */
    public function __construct()
    {
        $this->_database = Database::getInstance();
        $this->_defaultImageData = $this->_database->select('post_img', ['p_img_default', '=', '1'])->getResultFirstRecord();
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
     * @method                  getDefaultImageData
     * @desc                    Getter for _defaultImageData field.
     * @return                  array|null
     */
    public function getDefaultImageData()
    {
        return $this->_defaultImageData;
    }


    /**
     * @method                  selectPostImages
     * @desc                    Select all images details from post_img table. Does not select default image.
     * @return                  $this
     */
    public function selectImages()
    {
        $sql = "SELECT * FROM `post_img` WHERE `p_img_default` = '0'";

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
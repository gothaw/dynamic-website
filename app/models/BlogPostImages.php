<?php

class BlogPostImages
{
    private $_data;
    private $_database;
    private $_defaultImageData;
    private $_imagePath;
    private $_thumbnailPath;

    /**
     *                          BlogPostImages constructor.
     * @desc                    Sets database field and default image field. Also sets path for post images and thumbnails in dist folder.
     */
    public function __construct()
    {
        $this->_database = Database::getInstance();
        $this->_defaultImageData = $this->_database->select('post_image', ['p_img_default', '=', '1'])->getResultFirstRecord();
        $this->_imagePath = 'img/blog/post-img';
        $this->_thumbnailPath = 'img/blog/post-thumbnail';
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
     * @method              getImagePath
     * @desc                Gets post image path in dist folder.
     * @return              string
     */
    public function getImagePath()
    {
        return $this->_imagePath;
    }

    /**
     * @method              getThumbnailPath
     * @desc                Gets post image thumbnail path in dist folder.
     * @return              string
     */
    public function getThumbnailPath()
    {
        return $this->_thumbnailPath;
    }

    /**
     * @method                  selectPostImages
     * @desc                    Select all images details from post_image table. Does not select default image.
     * @return                  $this
     */
    public function selectImages()
    {
        $sql = "SELECT * FROM `post_image` WHERE `p_img_default` = '0'";

        $this->_data = $this->_database->query($sql)->getResult();

        return $this;
    }

    /**
     * @method                  selectImage
     * @param                   $blogImageId
     * @desc                    Selects image from the database for given p_img_id.
     * @return                  $this
     */
    public function selectImage($blogImageId)
    {
        $this->_data = $this->_database->select('post_image', ['p_img_id', '=', $blogImageId])->getResultFirstRecord();

        return $this;
    }

    /**
     * @method                  checkIfDefaultImage
     * @desc                    Checks if selected image is a default image. Requires setting data field with single image.
     * @return                  bool
     */
    public function checkIfDefaultImage()
    {
        return ($this->_data['p_img_default'] === '1') ? true : false;
    }

    /**
     * @method                  addImageDetails
     * @param                   $fields {array}
     * @desc                    Inserts details for a new blog post image to the database.
     * @throws                  Exception
     */
    public function addImageDetails($fields = [])
    {
        if (!$this->_database->insert('post_image', $fields)) {
            throw new Exception('There was a problem in adding new post image.');
        }
    }

    /**
     * @method                  deleteImageDetails
     * @param                   $blogImageId {int}
     * @desc                    Deletes blog post image details from the database. Does not delete default image.
     * @throws                  Exception
     */
    public function deleteImageDetails($blogImageId)
    {
        // Replaces blogImage id with default image id in blog posts
        $this->replacePostImagesWithDefaultImage($blogImageId);

        $sql = "DELETE FROM `post_image` WHERE `p_img_id` = ? AND `p_img_default` = 0;";

        $isDeleted = $this->_database->query($sql, [$blogImageId]);

        if (!$isDeleted) {
            throw new Exception('There was a problem in deleting blog post image');
        }
    }

    /**
     * @method                  replacePostImageWithDefaultImage
     * @param                   $blogImageId {int}
     * @desc                    Replaces given blog post image id in post table with default image id. Useful when given blog post image is to be deleted.
     * @throws                  Exception
     */
    private function replacePostImagesWithDefaultImage($blogImageId)
    {
        $defaultId = $this->_defaultImageData['p_img_id'];

        if (!$this->_database->update('post', 'p_img_id', $blogImageId, ['p_img_id' => $defaultId])) {
            throw new Exception('There was a problem in deleting blog post image from existing posts.');
        }
    }
}
<?php

/**
 *                              Class BlogSideBar
 * @desc                        Model for blog side bar. Allows for selecting data for blog side bar. This includes categories, tags and popular posts.
 */
class BlogSideBar
{
    private $_database;
    private $_categories;
    private $_tags;
    private $_popularPosts;

    /**
     *                          BlogSideBar constructor.
     * @desc                    Sets database field. Sets categories, tags and popular post on blog side bar.
     */
    public function __construct()
    {
        $this->_database = Database::getInstance();
        $this->setCategories();
        $this->setTags();
        $this->setPopularPosts();
    }

    /**
     * @method                  getCategories
     * @desc                    Getter for _categories field.
     * @return                  array|null
     */
    public function getCategories()
    {
        return $this->_categories;
    }

    /**
     * @method                  setCategories
     * @desc                    Sets post categories using SELECT DISTINCT on `post` table.
     */
    private function setCategories()
    {
        $sql = "SELECT DISTINCT `p_category`, COUNT(`p_category`) FROM `post` GROUP BY `p_category`;";

        $this->_categories = $this->_database->query($sql)->getResult();
    }

    /**
     * @method                  getTags
     * @desc                    Getter for _tags field.
     * @return                  array|null
     */
    public function getTags()
    {
        return $this->_tags;
    }

    /**
     * @method                  setTags
     * @desc                    Sets posts tags using SELECT DISTINCT on `post_tag` table.
     */
    private function setTags()
    {
        $sql = "SELECT DISTINCT `pt_text` FROM `post_tag`;";

        $this->_tags = $this->_database->query($sql)->getResult();
    }

    /**
     * @method                  getPopularPosts
     * @desc                    Getter for _popularPosts field.
     * @return                  array|null
     */
    public function getPopularPosts()
    {
        return $this->_popularPosts;
    }

    /**
     * @method                  setPopularPosts
     * @desc                    Sets popular posts on the side bar. Popularity measured by number of comments.
     */
    private function setPopularPosts()
    {
        $sql = "SELECT 
                    `post`.`p_id`,
                    `p_title`,
                    `p_date`,
                    `post_image`.`p_thumb_url`,
                    `post_image`.`p_img_alt`
                FROM 
                    `post`
                INNER JOIN
                    `post_image`
                ON
                    `post`.`p_img_id` = `post_image`.`p_img_id`
                ORDER BY `p_comments`
                DESC
                LIMIT 4";

        $this->_popularPosts = $this->_database->query($sql)->getResult();
    }
}
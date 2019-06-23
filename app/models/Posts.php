<?php

class Posts
{
    private $_database;
    private $_postData;
    private $_numberOfPages;
    private $_categories;
    private $_tags;

    /**
     *                          Posts constructor.
     * @desc                    Sets database field and details to be displayed on blog sidebar i.e. categories, tags.
     */
    public function __construct()
    {
        $this->_database = Database::getInstance();
        $this->setCategories();
        $this->setTags();
    }

    /**
     * @method                  getData
     * @desc                    Getter for _postData field.
     * @return                  array|null
     */
    public function getData()
    {
        return $this->_postData;
    }

    /**
     * @method                  getNumberOfPages
     * @desc                    Getter for _numberOfPages field.
     * @return                  int
     */
    public function getNumberOfPages()
    {
        return $this->_numberOfPages;
    }

    /**
     * @method                  setNumberOfPages
     * @desc                    Sets _numberOfPages field.
     */
    public function setNumberOfPages()
    {
        if (isset($this->_classesPerPage)) {
            $sql = "SELECT COUNT(*) FROM `post`";
            $rowCount = $this->_database->query($sql)->getResultFirstRecord()['COUNT(*)'];
            $this->_numberOfPages = ceil($rowCount / $this->_classesPerPage);
        }
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
    public function setTags()
    {
        $sql = "SELECT DISTINCT `pt_text` FROM `post_tag`;";

        $this->_tags = $this->_database->query($sql)->getResult();
    }


    /**
     * @method                  selectPosts
     * @param                   $postsPerPage {int}
     * @param                   $pageNumber {int}
     * @return                  $this
     * @desc                    Selects posts from the database based on the page number.
     */
    public function selectPosts($postsPerPage, $pageNumber)
    {
        // Gets number of posts equal to _postsPerPage but skips firsts $skipped posts
        $skipped = $postsPerPage * $pageNumber - $postsPerPage;

        $sql = "SELECT
                    *
                FROM 
                    `post`
                INNER JOIN
                    `post_img`
                ON
                    `post`.`p_img_id` = `post_img`.`p_img_id`
                ORDER BY
                    `post`.`p_date` DESC,
                    `post`.`p_time` DESC
                LIMIT ?,?;
                ";

        $this->_postData = $this->_database->query($sql, [(int)$skipped, (int)$postsPerPage])->getResult();
        $this->setPostSummary();

        return $this;
    }

    /**
     * @method                  setPostSummary
     * @desc                    Adds posts summary element for each post in _postData. Post summary is first 350 characters from `p_text` database field.
     *                          Requires setting _postData field.
     */
    private function setPostSummary()
    {
        if (isset($this->_postData)) {
            $tagsArray = ['<p>', '</p>', '<div>', '</div>', '<section>', '</section>'];
            $size = count($this->_postData);
            for ($i = 0; $i < $size; $i++) {
                $text = str_replace($tagsArray, '', $this->_postData[$i]['p_text']);
                $this->_postData[$i] = array_merge($this->_postData[$i],['p_summary' => substr($text, 0, 350) . '...']);
            }
        }
    }


}
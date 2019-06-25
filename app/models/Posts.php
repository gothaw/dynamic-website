<?php

class Posts
{
    private $_database;
    private $_postData;
    private $_categories;
    private $_tags;
    private $_numberOfPages;
    private $_currentPageNumber;

    /**
     *                          Posts constructor.
     * @desc                    Sets database field and details to be displayed on blog sidebar i.e. categories, tags.
     */
    public function __construct()
    {
        $this->_database = Database::getInstance();
        $this->setCategoriesSideBar();
        $this->setTagsSideBar();
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
     * @method                  getCurrentPageNumber
     * @desc                    Getter for _currentPageNumber field.
     * @return                  int
     */
    public function getCurrentPageNumber()
    {
        return $this->_currentPageNumber;
    }

    /**
     * @method                  setNumberOfPages
     * @param                   $postsPerPage {int}
     * @param                   $parameter {array}
     * @desc                    Sets _numberOfPages field.
     */
    private function setNumberOfPages($postsPerPage, $parameter)
    {
        if (isset($parameter['category'])) {
            $sql = "SELECT COUNT(*) FROM `post` WHERE `p_category` = ?";
            $rowCount = $this->_database->query($sql, [$parameter['category']])->getResultFirstRecord()['COUNT(*)'];
        } elseif (isset($parameter['tag'])) {
            $sql = "SELECT COUNT(*) FROM `post` INNER JOIN `post_tag` ON `post`.`p_id` = `post_tag`.`p_id` WHERE `pt_text` = ?";
            $rowCount = $this->_database->query($sql, [$parameter['tag']])->getResultFirstRecord()['COUNT(*)'];
        } else {
            $sql = "SELECT COUNT(*) FROM `post`";
            $rowCount = $this->_database->query($sql)->getResultFirstRecord()['COUNT(*)'];
        }
        $this->_numberOfPages = ceil($rowCount / $postsPerPage);
    }

    /**
     * @method                  setBlogPages
     * @param                   $postsPerPage {int}
     * @param                   $pageNumber {int}
     * @param                   $parameter {array}
     * @desc                    Sets total number of pages and current page fields.
     */
    private function setBlogPages($postsPerPage, $pageNumber, $parameter)
    {
        $this->setNumberOfPages($postsPerPage, $parameter);
        if ($pageNumber < '1' || $pageNumber > $this->_numberOfPages || !is_numeric($pageNumber)) {
            $this->_currentPageNumber = '1';
        } else {
            $this->_currentPageNumber = $pageNumber;
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
    private function setCategoriesSideBar()
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
    private function setTagsSideBar()
    {
        $sql = "SELECT DISTINCT `pt_text` FROM `post_tag`;";

        $this->_tags = $this->_database->query($sql)->getResult();
    }


    /**
     * @method                  selectPosts
     * @param                   $postsPerPage {int}
     * @param                   $pageNumber {int}
     * @param                   $category {string}
     * @desc                    Selects posts from the database based on the page number and/or category. Sets _postData field.
     *                          Post category is an optional parameter.
     * @return                  $this
     */
    public function selectPosts($postsPerPage, $pageNumber, $category = null)
    {
        // Sets blog pages
        $this->setBlogPages($postsPerPage, $pageNumber, ['category' => $category]);

        // Gets number of posts equal to _postsPerPage but skips firsts $skipped posts
        $skipped = $postsPerPage * $this->_currentPageNumber - $postsPerPage;

        $sql = "SELECT
                    *
                FROM 
                    `post`
                INNER JOIN
                    `post_img`
                ON
                    `post`.`p_img_id` = `post_img`.`p_img_id`";

        if (isset($category)) {
            $sql .= " WHERE `post`.`p_category` = ?
                    ORDER BY
                        `post`.`p_date` DESC,
                        `post`.`p_time` DESC
                    LIMIT ?,?;";
            $this->_postData = $this->_database->query($sql, [$category, $skipped, $postsPerPage])->getResult();
        } else {
            $sql .= " ORDER BY
                        `post`.`p_date` DESC,
                        `post`.`p_time` DESC
                    LIMIT ?,?;";
            $this->_postData = $this->_database->query($sql, [$skipped, $postsPerPage])->getResult();
        }

        $this->setPostSummary();
        $this->setPostTags();

        return $this;
    }

    /**
     * @method                  selectPostsByTag
     * @param                   $postsPerPage {int}
     * @param                   $pageNumber {int}
     * @param                   $tag {string}
     * @desc                    Selects posts from the database based on the page number and tag. Sets _postData field.
     * @return                  $this
     */
    public function selectPostsByTag($postsPerPage, $pageNumber, $tag)
    {
        // Sets blog pages
        $this->setBlogPages($postsPerPage, $pageNumber, ['tag' => $tag]);

        // Gets number of posts equal to _postsPerPage but skips firsts $skipped posts
        $skipped = $postsPerPage * $this->_currentPageNumber - $postsPerPage;

        $sql = "SELECT
                    *
                FROM 
                    `post`
                INNER JOIN
                    `post_img`
                ON
                    `post`.`p_img_id` = `post_img`.`p_img_id`
                INNER JOIN
                    `post_tag`
                ON  
                    `post`.`p_id` = `post_tag`.`p_id`
                WHERE 
                    `pt_text` = ?
                ORDER BY
                    `post`.`p_date` DESC,
                    `post`.`p_time` DESC
                LIMIT ?,?;
                ";

        $this->_postData = $this->_database->query($sql, [$tag, $skipped, $postsPerPage])->getResult();

        $this->setPostSummary();
        $this->setPostTags();

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
                $this->_postData[$i] = array_merge($this->_postData[$i], ['p_summary' => substr($text, 0, 350) . '...']);
            }
        }
    }

    /**
     * @method                  setPostTags
     * @desc                    Sets tags for posts in _postsData as arrays of values. Adds these arrays to _postData field using array_merge.
     *                          Uses select query with inner join between `post` and `post_tag` tables.
     */
    private function setPostTags()
    {
        if (isset($this->_postData)) {
            $idArray = [];
            $parameters = '';
            // creates a string with ? depending on the size of _postData array
            $i = 1;
            foreach ($this->_postData as $post) {
                $idArray [] = $post['p_id'];
                $parameters .= '?';
                if ($i < count($this->_postData)) {
                    $parameters .= ', ';
                }
                $i++;
            }
            $sql = "SELECT 
                        `post`.`p_id`,`pt_text` 
                    FROM 
                        `post` 
                    INNER JOIN 
                        `post_tag` 
                    ON 
                        `post`.`p_id` = `post_tag`.`p_id`
                    WHERE
                        `post`.`p_id` IN (" . $parameters . ")
                    ORDER BY
                        `post`.`p_id`
                    ASC";
            // Selects tags from the database
            $tags = $this->_database->query($sql, $idArray)->getResult();

            // Adds post tags to the _postData
            $size = count($this->_postData);
            for ($i = 0; $i < $size; $i++) {
                $postTags = [];
                foreach ($tags as $tag) {
                    if ($tag['p_id'] === $this->_postData[$i]['p_id']) {
                        $postTags [] = $tag['pt_text'];
                    }
                }
                $this->_postData[$i] = array_merge($this->_postData[$i], ['p_tags' => $postTags]);
            }
        }
    }


}
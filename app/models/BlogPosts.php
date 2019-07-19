<?php

class BlogPosts
{
    private $_data;
    private $_database;
    private $_numberOfPages;
    private $_currentPageNumber;

    /**
     *                          BlogPosts constructor.
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
     * @method                  selectPosts
     * @param                   $postsPerPage {int}
     * @param                   $pageNumber {int}
     * @param                   $category {string}
     * @param                   $includeSummaryAndTags {bool}
     * @desc                    Selects posts from the database based on the page number and/or category. Sets _data field.
     *                          Post category is an optional parameter.
     * @return                  $this
     */
    public function selectPosts($postsPerPage, $pageNumber, $category = null, $includeSummaryAndTags = true)
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
            $this->_data = $this->_database->query($sql, [$category, $skipped, $postsPerPage])->getResult();
        } else {
            $sql .= " ORDER BY
                        `post`.`p_date` DESC,
                        `post`.`p_time` DESC
                    LIMIT ?,?;";
            $this->_data = $this->_database->query($sql, [$skipped, $postsPerPage])->getResult();
        }

        if ($includeSummaryAndTags) {
            $this->setPostSummary();
            $this->setPostTags();
        }

        return $this;
    }

    /**
     * @method                  selectPostsByTag
     * @param                   $postsPerPage {int}
     * @param                   $pageNumber {int}
     * @param                   $tag {string}
     * @desc                    Selects posts from the database based on the page number and tag. Sets _data field.
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

        $this->_data = $this->_database->query($sql, [$tag, $skipped, $postsPerPage])->getResult();

        $this->setPostSummary();
        $this->setPostTags();

        return $this;
    }

    /**
     * @method                  selectPost
     * @param                   $postId {string}
     * @param                   $postTextInParagraphs {bool}
     * @desc                    Selects post form the database by $postId.
     * @return                  $this
     */
    public function selectPost($postId, $postTextInParagraphs = true)
    {
        $sql = "SELECT
                    *
                FROM 
                    `post`
                INNER JOIN
                    `post_img`
                ON
                    `post`.`p_img_id` = `post_img`.`p_img_id`
                WHERE 
                    `post`.`p_id` = ?;";

        $this->_data = $this->_database->query($sql, [$postId])->getResultFirstRecord();

        if ($postTextInParagraphs) {
            $this->setPostText();
        }
        $this->setPostTags();

        return $this;
    }

    /**
     * @method                  setPostSummary
     * @desc                    Adds posts summary element for each post in _data. Post summary is first 350 characters from `p_text` database field.
     *                          Requires setting _data field. Works only with multiple posts.
     */
    private function setPostSummary()
    {
        // Logic applies if multiple posts are set in _data
        if (isset($this->_data[0]) && is_array($this->_data[0])) {
            $size = count($this->_data);
            for ($i = 0; $i < $size; $i++) {
                $text = $this->_data[$i]['p_text'];
                $this->_data[$i] = array_merge($this->_data[$i], ['p_summary' => substr($text, 0, 350) . '...']);
            }
        }
    }

    /**
     * @method                  setPostText
     * @desc                    Replaces p_text field in _data field with array by exploding it by new line.
     *                          Each array element is a text paragraph. Works only with single post.
     */
    private function setPostText()
    {
        // Logic applies only if single post is set in _data
        if (isset($this->_data) && !(isset($this->_data[0]) && is_array($this->_data[0]))) {
            // Explodes by new line
            $textArray = preg_split('/\r\n|\r|\n/', $this->_data['p_text']);
            // Removes empty array elements
            $size = count($textArray);
            for ($i = 0; $i < $size; $i++) {
                if (empty($textArray[$i])) {
                    array_splice($textArray, $i, 1);
                }
            }
            $this->_data['p_text'] = $textArray;
        }
    }

    /**
     * @method                  setPostTags
     * @desc                    Sets tags for posts in _postsData as arrays of values. Adds these arrays to _data field using array_merge.
     *                          Uses select query with inner join between `post` and `post_tag` tables.
     */
    private function setPostTags()
    {
        if (isset($this->_data)) {
            $idArray = [];
            $parameters = '';

            // creates a string with ? depending on the size of _data array
            if (isset($this->_data[0]) && is_array($this->_data[0])) {
                // Logic for multiple posts
                $i = 1;
                foreach ($this->_data as $post) {
                    $idArray [] = $post['p_id'];
                    $parameters .= '?';
                    if ($i < count($this->_data)) {
                        $parameters .= ', ';
                    }
                    $i++;
                }
            } else {
                // Logic for single post
                $idArray [] = $this->_data['p_id'];
                $parameters = '?';
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

            // Adds post tags to the _data
            if (isset($this->_data[0]) && is_array($this->_data[0])) {
                // Logic for multiple posts
                $size = count($this->_data);
                for ($i = 0; $i < $size; $i++) {
                    $postTags = [];
                    foreach ($tags as $tag) {
                        if ($tag['p_id'] === $this->_data[$i]['p_id']) {
                            $postTags [] = $tag['pt_text'];
                        }
                    }
                    $this->_data[$i] = array_merge($this->_data[$i], ['p_tags' => $postTags]);
                }
            } else {
                // Logic for single post
                $postTags = [];
                foreach ($tags as $tag) {
                    $postTags [] = $tag['pt_text'];
                }
                $this->_data = array_merge($this->_data, ['p_tags' => $postTags]);
            }
        }
    }

    /**
     * @method                  addPost
     * @param                   $fields {array}
     * @desc                    Adds new blog post to the database.
     * @throws                  Exception
     */
    public function addPost($fields = [])
    {
        if (!$this->_database->insert('post', $fields)) {
            throw new Exception('There was a problem adding the blog post.');
        }
    }

    /**
     * @method                  updatePost
     * @param                   $postId
     * @param                   $fields {array}
     * @desc                    Updates blog posts in the database.
     * @throws                  Exception
     */
    public function updatePost($postId, $fields = [])
    {
        if (!$this->_database->update('post', 'p_id', $postId, $fields)) {
            throw new Exception('There was a problem in updating the blog post.');
        }
    }

    /**
     * @method                  deletePost
     * @param                   $postId
     * @desc                    Method deletes post from the database.
     * @throws                  Exception
     */
    public function deletePost($postId)
    {
        if (!$this->_database->delete('post', ['p_id', '=', $postId])) {
            throw new Exception("There was problem deleting existing post tags");
        }
    }

    /**
     * @method                  findMostRecentPostById
     * @desc                    Selects the most recently added post to the database. That is with highest p_id.
     * @return                  int|null
     */
    public function findMostRecentPostById()
    {
        $sql = "SELECT `p_id` FROM `post` ORDER BY `p_id` DESC LIMIT 1 ";

        $post = $this->_database->query($sql)->getResultFirstRecord();

        if (isset($post)) {
            return $post['p_id'];
        } else {
            return null;
        }
    }
}
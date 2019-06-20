<?php

class Posts
{
    private $_data;
    private $_database;
    private $_postsPerPage;
    private $_numberOfPages;

    /**
     *                                  Posts constructor.
     * @param                           $postsPerPage
     * @desc                            Sets database field
     */
    public function __construct($postsPerPage)
    {
        $this->_postsPerPage = $postsPerPage;
        $this->_database = Database::getInstance();
    }

    /**
     * @method              getData
     * @desc                Getter for _data field.
     * @return              array|null
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
     * @method                  selectPosts
     * @param                   $pageNumber {int}
     * @desc                    Selects posts from the database based on the page number.
     * @return                  $this
     */
    public function selectPosts($pageNumber)
    {
        // Gets number of posts equal to _postsPerPage but skips firsts $skipped posts
        $skipped = $this->_postsPerPage * $pageNumber - $this->_postsPerPage;

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

        $this->_data = $this->_database->query($sql, [(int)$skipped, (int)$this->_postsPerPage])->getResult();

        return $this;
    }


}
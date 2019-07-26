<?php

class BlogComments
{
    private $_data;
    private $_database;
    private $_numberOfPages;
    private $_currentPageNumber;

    /**
     *                          BlogComments constructor.
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
     * @param                   $commentsPerPage {int}
     * @param                   $isApproved {bool}
     * @desc                    Sets _numberOfPages field.
     */
    private function setNumberOfPages($commentsPerPage, $isApproved)
    {
        $approvedComments = ($isApproved) ? 1 : 0;

        $sql = "SELECT COUNT(*) FROM `post_comment` WHERE `pc_approved` = {$approvedComments}";

        $rowCount = $this->_database->query($sql)->getResultFirstRecord()['COUNT(*)'];

        $this->_numberOfPages = ceil($rowCount / $commentsPerPage);
    }

    /**
     * @method                  setCommentAdminAreaPages
     * @param                   $commentsPerPage {int}
     * @param                   $pageNumber {int}
     * @param                   $isApproved {bool}
     * @desc                    Sets total number of pages and current page fields. Validates parameter for current page number.
     */
    private function setCommentAdminAreaPages($commentsPerPage, $pageNumber, $isApproved)
    {
        $this->setNumberOfPages($commentsPerPage, $isApproved);
        if ($pageNumber < '1' || $pageNumber > $this->_numberOfPages || !is_numeric($pageNumber)) {
            $this->_currentPageNumber = '1';
        } else {
            $this->_currentPageNumber = $pageNumber;
        }
    }

    /**
     * @method                  selectPostComments
     * @param                   $postId
     * @desc                    Selects comments from the database for selected post.
     *                          Selects only approved posts and order them by date and time.
     * @return                  $this
     */
    public function selectPostComments($postId)
    {
        $sql = "SELECT
                    * 
                FROM 
                    `post_comment` 
                WHERE
                    `p_id` = ? AND `pc_approved` = 1
                ORDER BY
                    `pc_date` ASC,
                    `pc_time` ASC;
               ";

        $this->_data = $this->_database->query($sql, [$postId])->getResult();

        return $this;
    }

    /**
     * @method                  selectComment
     * @param                   $postCommentId
     * @desc                    Selects comment from the database base on the post comment id.
     * @return                  $this
     */
    public function selectComment($postCommentId)
    {
        $this->_data = $this->_database->select('post_comment', ['pc_id', '=', $postCommentId])->getResultFirstRecord();

        return $this;
    }

    /**
     * @method                  selectCommentsForApproval
     * @param                   $commentsPerPage {int}
     * @param                   $pageNumber {int}
     * @desc                    Selects comments for approval from the database. Sets _data field.
     *                          Comments in admin panel are listed in a table with a number of comments per page.
     * @return                  $this
     */
    public function selectCommentsForApproval($commentsPerPage, $pageNumber)
    {
        // Set comment admin area pages
        $this->setCommentAdminAreaPages($commentsPerPage, $pageNumber, false);

        // Gets number of comments equal to _commentsPerPage but skips first $skipped comments
        $skipped = $commentsPerPage * $this->_currentPageNumber - $commentsPerPage;

        $sql = "SELECT
                    `post_comment`.*,
                    `post`.`p_title`
                FROM 
                    `post_comment`
                INNER JOIN
                    `post`
                ON `post`.`p_id` = `post_comment`.`p_id`
                WHERE 
                    `pc_approved` = 0
                ORDER BY
                        `pc_date` ASC,
                        `pc_time` ASC
                LIMIT ?,?;";

        $this->_data = $this->_database->query($sql, [$skipped, $commentsPerPage])->getResult();

        return $this;
    }

    /**
     * @method                  addComment
     * @param                   $fields {array}
     * @desc                    Adds new comment to the database
     * @throws                  Exception
     */
    public function addComment($fields = [])
    {
        if (!$this->_database->insert('post_comment', $fields)) {
            throw new Exception("There was a problem in adding the comment. Sorry.");
        }
    }

    /**
     * @method                  updateComment
     * @param                   $postCommentId
     * @param                   $fields {array}
     * @desc                    Updates comment with $postCommentId in the database.
     * @throws                  Exception
     */
    public function updateComment($postCommentId, $fields = [])
    {
        if (!$this->_database->update('post_comment', 'pc_id', $postCommentId, $fields)) {
            throw new Exception("There was a problem in updating post comment");
        }
    }

    /**
     * @method                  deleteComment
     * @param                   $postCommentId
     * @desc                    Deletes comment with $postCommentId from the database.
     * @throws                  Exception
     */
    public function deleteComment($postCommentId)
    {
        if (!$this->_database->delete('post_comment', ['pc_id', '=', $postCommentId])) {
            throw new Exception("There was a problem in deleting the post comment");
        }
    }

    /**
     * @method                  deleteCommentsByPostId
     * @param                   $postId
     * @desc                    Deletes all post comments with given p_id.
     * @throws                  Exception
     */
    public function deleteCommentsByPostId($postId)
    {
        if (!$this->_database->delete('post_comment', ['p_id', '=', $postId])) {
            throw new Exception("There was a problem in deleting comments for given post.");
        }
    }
}
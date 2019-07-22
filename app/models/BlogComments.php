<?php

class BlogComments
{
    private $_data;
    private $_database;

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
     *
     */
    public function selectCommentsForApproval()
    {

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
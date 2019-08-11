<?php

/**
 *                              Class BlogPostTags
 * @desc                        Model for blog post tags. Allows for adding, deleting and updating tags data in `post_tag` table.
 */
class BlogPostTags
{
    private $_database;

    /**
     *                          BlogPostTags constructor.
     * @desc                    Sets database field.
     */
    public function __construct()
    {
        $this->_database = Database::getInstance();
    }

    /**
     * @method                  insertTags
     * @param                   $postId {int}
     * @param                   $tagString {string} string of tags separated with commas
     * @desc                    Inserts new tags to the database. Uses prepared statement carried out by query method from the database object.
     * @throws                  Exception
     */
    public function insertTags($postId, $tagString)
    {
        $tagTextArray = explode(',', $tagString);

        $size = count($tagTextArray);
        $placeholderString = '';

        for ($i = 0; $i < $size; $i++) {
            $placeholderString .= "(?, ?)";
            if ($i < $size - 1) {
                $placeholderString .= ", ";
            }
        }

        $valuesArray = [];

        foreach ($tagTextArray as $tag) {
            array_push($valuesArray, $postId, strtolower(trim($tag)));
        }

        $sql = "INSERT INTO `post_tag` (`p_id`, `pt_text`) VALUES " . $placeholderString . ";";

        if (!$this->_database->query($sql, $valuesArray)) {
            throw new Exception("There was problem adding new post tags");
        }
    }

    /**
     * @method                  deleteTags
     * @param                   $postId {int}
     * @desc                    Method deletes tags from the database for given p_id.
     * @throws                  Exception
     */
    public function deleteTags($postId)
    {
        if (!$this->_database->delete('post_tag', ['p_id', '=', $postId])) {
            throw new Exception("There was problem deleting existing post tags");
        }
    }

    /**
     * @method                  updateTags
     * @param                   $postId {int}
     * @param                   $tagString {string} string of tags separated with commas
     * @desc                    Method deletes existing post tags and adds new tags to the database.
     *                          Uses deleteTags and insertTags methods.
     * @throws                  Exception
     */
    public function updateTags($postId, $tagString)
    {
        $this->deleteTags($postId);
        $this->insertTags($postId, $tagString);
    }
}
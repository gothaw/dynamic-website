<?php

class BlogPostTags
{
    private $_data;
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
     * @param                   $tagString {string} string of tags separated with commas, spaces or semicolons
     * @throws                  Exception
     */
    public function updateTags($postId, $tagString)
    {
        if (!$this->_database->delete('post_tag', ['p_id', '=', $postId])) {
            throw new Exception("There was problem deleting existing post tags");
        }

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
     * @param $postId
     * @param $tagString
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

        trace($valuesArray);
    }
}
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
    public function insertTags($postId, $tagString)
    {
        $stringWithoutDelimiters = str_replace(',', '', str_replace(';', '', $tagString));
        $tagTextArray = explode(' ', $stringWithoutDelimiters);

        /*if (!$this->_database->delete('post_tag', ['p_id', '=', $postId])) {
            throw new Exception("There was problem deleting existing post tags");
        }*/

        $size = count($tagTextArray);
        $valuesString = '';

        for ($i = 0; $i < $size; $i++) {
            $valuesString .= "(?, ?)";
            if ($i < $size - 1) {
                $valuesString .= ", ";
            }
        }

        $valuesArray = [];

        foreach ($tagTextArray as $tag) {
            $valuesArray [] = $postId;
         }

        /*$sql = "INSERT INTO `post_tag` (`p_id`,`pt_text`) VALUES ${$valuesString}";*/

        echo $valuesString;
    }
}
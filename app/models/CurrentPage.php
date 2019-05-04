<?php

class CurrentPage
{
    private $_data = null;

    /**
     *                      CurrentPage constructor.
     * @param               $pageName {string}
     * @desc                Selects page that has pg_name equal to $pageName.
     */
    public function __construct($pageName)
    {
        $database = Database::getInstance();
        $this->_data = $database->select('page', ['pg_name', '=', $pageName])->getResultFirstRecord();
    }

    /**
     * @method              getPageDetails
     * @desc                Getter for _data field.
     * @return              array|null
     */
    public function getPageDetails()
    {
        return $this->_data;
    }

    /**
     * @method              getPageUrl
     * @desc                Returns url of the current page from _data field.
     * @return              mixed
     */
    public function getPageUrl()
    {
        return $this->_data['pg_url'];
    }
}
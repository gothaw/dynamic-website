<?php

/**
 *                          Class CurrentPage
 * @desc                    Model for current page details. Allows for selecting this page info from `page` table. This includes page name, keywords, footer theme, banner type.
 */
class CurrentPage
{
    private $_data;
    private $_database;

    /**
     *                      CurrentPage constructor.
     * @param               $pageName {string}
     * @desc                Selects page that has pg_name equal to $pageName.
     */
    public function __construct($pageName)
    {
        $this->_database = Database::getInstance();
        $this->_data = $this->_database->select('page', ['pg_name', '=', $pageName])->getResultFirstRecord();
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
     * @method              getPageUrl
     * @desc                Returns url of the current page from _data field.
     * @return              mixed
     */
    public function getPageUrl()
    {
        return $this->_data['pg_url'];
    }
}
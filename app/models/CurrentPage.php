<?php

class CurrentPage
{
    private $_data = null;

    public function __construct($pageName)
    {
        $database = Database::getInstance();
        $this->_data = $database->select('page', ['pg_name', '=', $pageName])->getResultFirstRecord();
    }

    public function getPageDetails()
    {
        return $this->_data;
    }

    public function getPageUrl()
    {
        return $this->_data['pg_url'];
    }
}
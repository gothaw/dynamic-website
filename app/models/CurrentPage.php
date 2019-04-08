<?php

class CurrentPage
{
    private $_data = null;

    private function loadData($pageName)
    {
        $database = Database::getInstance();
        $this->_data = $database->select('page', ['pg_name', '=', $pageName])->getResultSingleRecord();
    }

    public function getPageDetails($pageName)
    {
        $this->loadData($pageName);
        return $this->_data;
    }

    public function getPageUrl($pageName)
    {
        return $this->getPageDetails($pageName)['pg_url'];
    }
}
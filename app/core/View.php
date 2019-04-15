<?php

class View
{
    private $_viewName;
    private $_viewPath;
    private $_viewData;
    private $_error;
    private $_isLoggedIn;

    public function __construct($viewName, $viewPath, $viewData)
    {
        $this->_viewName = $viewName;
        $this->_viewPath = $viewPath;
        $this->_viewData = $viewData;
    }

    public function setViewError($error)
    {
        $this->_error = $error;
    }

    public function getViewError()
    {
        return $this->_error;
    }

    public function setIsLoggedIn($boolean)
    {
        $this->_isLoggedIn = $boolean;
    }

    public function getIsLoggedIn()
    {
        return $this->_isLoggedIn;
    }

    public function renderView($includeStandardBanner = true)
    {
        // SIMPLIFYING VARIABLES
        $data = $this->_viewData;
        $name = $this->_viewName;
        $isLoggedIn = $this->_isLoggedIn;

        // HEAD
        include("../app/views/_includes/top.php");

        // HEADER AND PRELOADER
        include("../app/views/_includes/preloader.php");
        include("../app/views/_includes/header.php");

        if ($includeStandardBanner) {
            include("../app/views/_includes/banner.php");
        }

        // CONTENT
        require_once '../app/views/' . $this->_viewPath . 'index.php';

        // FOOTER
        include("../app/views/_includes/footer.php");
    }
}
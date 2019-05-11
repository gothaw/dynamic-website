<?php

class View
{
    private $_viewName;
    private $_viewSubName = 'index';
    private $_viewPath;
    private $_viewData;
    private $_error;
    private $_userIsLoggedIn;

    /**
     *                              View constructor.
     * @param                       $viewName {string}
     * @param                       $viewPath {path to index.php file in views folder e.g. for home page 'home/'}
     * @param                       $viewData {data as an associative array}
     * @desc                        Sets view name, path and data.
     */
    public function __construct($viewName, $viewPath, $viewData)
    {
        $this->_viewName = $viewName;
        $this->_viewPath = $viewPath;
        $this->_viewData = $viewData;
    }

    /**
     * @method                      setViewError
     * @param                       $error {string}
     * @desc                        Sets view error message.
     *                              This could include error messages such as invalid input in registration or login error.
     */
    public function setViewError($error)
    {
        $this->_error = $error;
    }

    /**
     * @method                      getViewError
     * @desc                        Gets view error message.
     * @return                      string
     */
    public function getViewError()
    {
        return $this->_error;
    }

    /**
     * @method                      setUserIsLoggedIn
     * @param                       $boolean
     * @desc                        Sets if user is logged in.
     */
    public function setUserIsLoggedIn($boolean)
    {
        $this->_userIsLoggedIn = $boolean;
    }

    /**
     * @method                      getIsLoggedIn
     * @desc                        Gets userIsLoggedIn field.
     * @return                      bool
     */
    public function getIsLoggedIn()
    {
        return $this->_userIsLoggedIn;
    }

    /**
     * @method                      setSubName
     * @param                       $name {string}
     * @desc                        Sets secondary name for the view.
     */
    public function setSubName($name)
    {
        $this->_viewSubName = $name;
    }

    /**
     * @method                      addViewData
     * @param                       $data {array}
     * @desc                        Appends additional data to the _viewData field.
     */
    public function addViewData($data)
    {
        $this->_viewData = array_merge($this->_viewData,$data);
    }

    /**
     * @method                      renderView
     * @param                       $includeStandardBanner {bool}
     * @desc                        Displays view in by including index.php file using _viewPath.
     *                              It also includes document head, navigation bar and footer.
     */
    public function renderView($includeStandardBanner = true)
    {
        // SIMPLIFYING VARIABLES
        $data = $this->_viewData;
        $name = $this->_viewName;
        $subName = $this->_viewSubName;
        $userIsLoggedIn = $this->_userIsLoggedIn;

        // HEAD
        include("../app/views/_includes/top.php");

        // HEADER AND PRELOADER
        include("../app/views/_includes/preloader.php");
        include("../app/views/_includes/header.php");

        if ($includeStandardBanner) {
            include("../app/views/_includes/banner.php");
        }

        // CONTENT
        require_once '../app/views/' . $this->_viewPath . '/index.php';

        // FOOTER
        include("../app/views/_includes/footer.php");
    }
}
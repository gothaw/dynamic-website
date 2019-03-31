<?php

class View
{
    private $viewName;
    private $viewPath;
    private $viewData;

    public function __construct($viewName, $viewPath, $viewData)
    {
        $this->viewName = $viewName;
        $this->viewPath = $viewPath;
        $this->viewData = $viewData;
    }

    public function renderView($includeStandardBanner = true)
    {

        // SIMPLIFYING VARIABLES
        $data = $this->viewData;
        $name = $this->viewName;

        // HEAD
        include("../app/views/_includes/top.php");

        // HEADER AND PRELOADER
        include("../app/views/_includes/preloader.php");
        include("../app/views/_includes/header.php");

        if ($includeStandardBanner) {
            include("../app/views/_includes/banner.php");
        }

        // CONTENT
        require_once '../app/views/' . $this->viewPath . 'index.php';

        // FOOTER
        include("../app/views/_includes/footer.php");
    }
}
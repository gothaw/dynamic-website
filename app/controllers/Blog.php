<?php

class Blog extends Controller
{
    private $_page;

    public function __construct()
    {
        $this->_page = 'blog';

        parent::__construct($this->_page);

        $this->view($this->_page, $this->_path, [
            'navPages' => $this->_navPages,
            'pageDetails' => $this->_pageDetails
        ]);
    }

    public function index()
    {
        $this->_view->renderView();
    }
}
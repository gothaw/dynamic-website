<?php

class Blog extends Controller
{
    private $_page;
    private $_posts;
    private $_lastPage;

    public function __construct()
    {
        $this->_page = 'blog';

        parent::__construct($this->_page);

        $this->_posts = $this->model('Posts', 4);
        $this->_posts->setNumberOfPages();
        $this->_lastPage = $this->_posts->getNumberOfPages();

        $this->view($this->_page, $this->_path, [
            'navPages' => $this->_navPages,
            'pageDetails' => $this->_pageDetails
        ]);
    }

    public function index($page = '1')
    {
        $this->_posts->selectPosts($page);
        trace($this->_posts->getData());
        $this->_view->renderView();
    }
}
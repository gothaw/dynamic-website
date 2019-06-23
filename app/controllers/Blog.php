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

        $this->_posts = $this->model('Posts');
        $this->_posts->setNumberOfPages();
        $this->_lastPage = $this->_posts->getNumberOfPages();

        $this->view($this->_page, $this->_path, [
            'navPages' => $this->_navPages,
            'pageDetails' => $this->_pageDetails,
            'categories' => $this->_posts->getCategories(),
            'tags' => $this->_posts->getTags()
        ]);
    }

    public function index($page = '1')
    {
        if ($page < '1' || $page > $this->_lastPage || !is_numeric($page)) {
            $page = '1';
        }
        $this->_posts->selectPosts(4, $page);
        $this->_view->addViewData([
            'posts' => $this->_posts->getData(),
            'page' => $page
        ]);
        $this->_view->renderView();
    }
}
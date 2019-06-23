<?php

class Blog extends Controller
{
    private $_page;
    private $_posts;

    public function __construct()
    {
        $this->_page = 'blog';

        parent::__construct($this->_page);

        $this->_posts = $this->model('Posts');

        $this->view($this->_page, $this->_path, [
            'navPages' => $this->_navPages,
            'pageDetails' => $this->_pageDetails,
            'categories' => $this->_posts->getCategories(),
            'tags' => $this->_posts->getTags()
        ]);
    }

    public function index($page = '1')
    {
        $this->_posts->selectPosts(4, $page);
        $this->_view->addViewData([
            'posts' => $this->_posts->getData(),
            'page' => $this->_posts->getCurrentPageNumber(),
            'lastPage' => $this->_posts->getNumberOfPages()
        ]);
        $this->_view->renderView();
    }
}
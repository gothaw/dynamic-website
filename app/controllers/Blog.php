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
        $this->_view->setSubName(toLispCase(__CLASS__));
        $this->_view->renderView();
    }

    public function tag($tag = '', $page = '1')
    {
        $tag = str_replace('_',' ',$tag);

        // Validation using Validate object
        $validate = new Validate();
        $validate->check(['tag' => $tag], ValidationRules::getValidPostTagRules());

        if($validate->checkIfPassed()){

            $this->_posts->selectPostsByTag(4, $page, $tag);

            $this->_view->addViewData([
                'posts' => $this->_posts->getData(),
                'page' => $this->_posts->getCurrentPageNumber(),
                'lastPage' => $this->_posts->getNumberOfPages()
            ]);
            $this->_view->setSubName(toLispCase(__CLASS__) . '/' . __FUNCTION__ . '/' . escape($tag));
            $this->_view->renderView();

        } else {
            Redirect::to('blog');
        }
    }

    public function category($category = '', $page = '1')
    {
        $category = str_replace('_',' ',$category);

        // Validation using Validate object
        $validate = new Validate();
        $validate->check(['category' => $category], ValidationRules::getValidPostCategoryRules());

        if($validate->checkIfPassed()){

            $this->_posts->selectPosts(4, $page, $category);

            $this->_view->addViewData([
                'posts' => $this->_posts->getData(),
                'page' => $this->_posts->getCurrentPageNumber(),
                'lastPage' => $this->_posts->getNumberOfPages()
            ]);
            $this->_view->setSubName(toLispCase(__CLASS__) . '/' . __FUNCTION__ . '/' . escape($category));
            $this->_view->renderView();

        } else {
            Redirect::to('blog');
        }
    }

    public function post($postId = '')
    {

    }
}
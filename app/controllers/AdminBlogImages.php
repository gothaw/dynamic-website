<?php

class AdminBlogImages extends Controller
{
    private $_page;
    private $_blogImages;

    public function __construct()
    {
        $this->_page = 'admin';
        parent::__construct($this->_page);

        if ($this->_user->isLoggedIn() && $this->_user->hasPermission('admin')) {

            $userData = $this->_user->getData();

            $this->_blogImages = $this->model('BlogPostImages');

            $this->view($this->_page, $this->_path, [
                'navPages' => $this->_navPages,
                'pageDetails' => $this->_pageDetails,
                'user' => $userData,
            ]);
        } else {
            Redirect::to('home');
        }
    }

    public function index()
    {
        $this->_blogImages->selectImages();
        $this->_view->addViewData([
            'images' => $this->_blogImages->getData(),
            'defaultImage' => $this->_blogImages->getDefaultImageData()
        ]);
        $this->_view->setSubName(toLispCase(__CLASS__));
        $this->_view->renderView();
    }
}
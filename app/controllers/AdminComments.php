<?php

class AdminComments extends Controller
{
    private $_page;
    private $_comments;

    public function __construct()
    {
        $this->_page = 'admin';
        parent::__construct($this->_page);

        if ($this->_user->isLoggedIn() && $this->_user->hasPermission('admin')) {

            $userData = $this->_user->getData();

            $this->_comments = $this->model('BlogComments');

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
        $this->_view->addViewData([
            'comments' => $this->_comments->getData()
        ]);
        $this->_view->setSubName(toLispCase(__CLASS__));
        $this->_view->renderView();
    }
}
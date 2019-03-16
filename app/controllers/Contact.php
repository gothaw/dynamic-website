<?php

class Contact extends Controller
{
    protected $_page;
    protected $_navPages;
    protected $_user;
    protected $_failMessage;

    public function __construct()
    {
        $this->_failMessage = $this->returnDatabaseMessage();
        $this->_navPages = $this->model('NavBarPages');
        $this->_page = $this->model('CurrentPage');
        $this->_user = $this->model('User');
    }

    public function index($name = ''){
        $thisPage='contact';
        $path='contact';

        print_r($this->_failMessage);

        $navPages = $this->_navPages->getNavBarPages();
        $pageDetails = $this->_page->getPageDetails($thisPage);
        $this->_user->name = $name;

        $this->view($thisPage,$path, ['name'=>$name,'navPages' => $navPages, 'pageDetails' => $pageDetails ]);
        $this->_view->renderView();
    }
}
<?php

class Contact extends Controller
{
    protected $page;
    protected $navPages;
    protected $user;
    protected $failMessage;

    public function __construct()
    {
        $this->failMessage = $this->returnDatabaseMessage();
        $this->navPages = $this->model('NavBarPages');
        $this->page = $this->model('CurrentPage');
        $this->user = $this->model('User');
    }

    public function index($name = ''){
        $thisPage='contact';
        $path='contact';

        print_r($this->failMessage);

        $navPages = $this->navPages->getNavBarPages();
        $pageDetails = $this->page->getPageDetails($thisPage);
        $this->user->name = $name;

        $this->view($thisPage,$path, ['name'=>$name,'navPages' => $navPages, 'pageDetails' => $pageDetails ]);
        $this->view->renderView();
    }
}
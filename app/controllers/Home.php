<?php

class Home extends Controller{

    protected $page;
    protected $nav_pages;
    protected $user;

    public function __construct()
    {
        $this->nav_pages = $this->model('NavBarPages');
        $this->page = $this->model('CurrentPage');
        $this->user = $this->model('User');
    }

    public function index($name = ''){
        $this_page='home';
        $path='index';

        if(!empty($this->nav_pages->returnFailMessage())){
            print_r($this->nav_pages->returnFailMessage());
        }

        $nav_pages = $this->nav_pages->getNavBarPages();
        $page_details = $this->page->getPageDetails($this_page);
        $this->user->name = $name;

        $this->view($this_page,$path, ['name'=>$name,'nav_pages' => $nav_pages, 'page_details' => $page_details ]);
        $this->view->renderView();
    }

}
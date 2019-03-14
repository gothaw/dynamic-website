<?php

class Home extends Controller{

    protected $page;
    protected $nav_pages;
    protected $fail_message;

    public function __construct()
    {
        $this->fail_message = $this->databaseMsg();
        $this->nav_pages = $this->model('NavBarPages');
        $this->page = $this->model('CurrentPage');
    }

    public function index(){
        $this_page='home';
        $path='index';

        $nav_pages = $this->nav_pages->getNavBarPages();
        $page_details = $this->page->getPageDetails($this_page);

        $this->view($this_page,$path, ['nav_pages' => $nav_pages, 'page_details' => $page_details, 'fail_message'=>$this->fail_message]);
        $this->view->renderView();
    }

}
<?php

class contact extends Controller
{
    protected $page;
    protected $nav_pages;
    protected $user;
    protected $fail_message;

    public function __construct()
    {
        $this->fail_message = $this->databaseMsg();
        $this->nav_pages = $this->model('NavBarPages');
        $this->page = $this->model('CurrentPage');
        $this->user = $this->model('User');
    }

    public function index($name = ''){
        $this_page='contact';
        $path='contact';

        print_r($this->fail_message);

        $nav_pages = $this->nav_pages->getNavBarPages();
        $page_details = $this->page->getPageDetails($this_page);
        $this->user->name = $name;

        $this->view($this_page,$path, ['name'=>$name,'nav_pages' => $nav_pages, 'page_details' => $page_details ]);
        $this->view->renderView();
    }
}
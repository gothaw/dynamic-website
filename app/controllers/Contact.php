<?php

class contact extends Controller
{
    protected $user;
    protected $nav_pages;
    protected $page;

    public function __construct()
    {
        $this->nav_pages = $this->model('NavBarPages');
        $this->page = $this->model('CurrentPage');
        $this->user = $this->model('User');
    }

    public function index($name = ''){
        $this_page='contact';
        $path='contact';

        if(!empty($this->nav_pages->returnFailMessage())){
            print_r($this->nav_pages->returnFailMessage());
        }

        $nav_pages = $this->nav_pages->getNavBarPages();
        $page_details = $this->page->getPageDetails($this_page);
        $this->user->name = $name;

        $this->view($this_page,$path, ['name'=>$name,'nav_pages' => $nav_pages, 'page_details' => $page_details ]);
    }
}
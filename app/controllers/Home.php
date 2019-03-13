<?php

class Home extends Controller{

    public function index($name = ''){
        $user = $this->model('User');
        $nav_pages = $this->model('NavBarPages');

        if(!empty($nav_pages->returnFailMessage())){
            print_r($nav_pages->returnFailMessage());
        }

        $user->name = $name;
        $nav_pages = $nav_pages->getNavBarPages();


        $this->view('home','index', ['name' => $user->name, 'nav_pages' => $nav_pages ]);
        $this->view->renderView();
    }
}
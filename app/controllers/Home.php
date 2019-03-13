<?php

class Home extends Controller{

    public function index($name = ''){
        $user = $this->model('User');
        $nav_bar_pages = $this->model('NavBarPages');

        if(!empty($nav_bar_pages->returnFailMessage())){
            print_r($nav_bar_pages->returnFailMessage());
        }

        $user->name = $name;
        $pages = $nav_bar_pages->getNavBarPages();


        echo '</br>';
        $this->view('index', ['name' => $user->name, 'pages' => $pages ]);
        $this->view->setViewName('home');
        $this->view->renderView();
    }
}
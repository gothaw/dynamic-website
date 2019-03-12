<?php

class Home extends Controller{

    public function index($name = ''){
        $user = $this->model('User');
        $pages = $this->model('Page');

        $user->name = $name;

        print_r($pages->getAllPages());

        $this->view('index', ['name' => $user->name]);
        $this->view->setTitle('meow meow');
        $this->view->render();

    }
}
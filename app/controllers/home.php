<?php

class Home extends Controller{

    public function index($name = ''){
        $user = $this->model('User');
        $user->name = $name;
        $pages = $this->model('Page')->getAllPages();
        //print_r($pages);
        echo '</br>';
        $this->view('index', ['name' => $user->name, 'pages' => $pages ]);
        $this->view->setTitle('meow meow');
        $this->view->render();

    }
}
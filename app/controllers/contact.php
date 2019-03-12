<?php

class contact extends Controller
{
    public function index(){
        $this->model('User');
        $this->view('contact');
        $this->view->render();
        print_r($this);
    }
}
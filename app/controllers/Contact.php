<?php

class Contact extends Controller
{
    private $_page;
    private $_user = null;

    public function __construct()
    {
        $this->_page = 'contact';

        $this->_user = $this->model('User');

        parent::__construct($this->_page);
    }

    public function index($name = '')
    {
        $this->_user->name = $name;

        $this->view($this->_page, $this->_path, [
            'navPages' => $this->_navPages,
            'pageDetails' => $this->_pageDetails,
            'userName' => $this->_user->name
        ]);

        $this->_view->renderView();
    }
}
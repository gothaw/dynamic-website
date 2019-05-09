<?php

class About extends Controller
{
    private $_page;
    private $_classes;
    private $_coaches;

    public function __construct()
    {
        $this->_page = 'about';

        $this->_classes = $this->model('Classes');
        $this->_classes->selectClasses();

        $this->_coaches = $this->model('Coaches');
        $this->_coaches->selectCoaches();

        parent::__construct($this->_page);

        $this->view($this->_page, $this->_path, [
            'navPages' => $this->_navPages,
            'pageDetails' => $this->_pageDetails,
            'classes' => $this->_classes->getData(),
            'coaches' => $this->_coaches->getData()
        ]);
    }

    public function index()
    {
        $this->_view->renderView();
    }
}
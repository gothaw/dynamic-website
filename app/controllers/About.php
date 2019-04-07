<?php

class About extends Controller
{
    private $_page;
    private $_classes = null;
    private $_coaches = null;

    public function __construct()
    {
        $this->_page = 'about';
        $this->_classes = $this->model('Classes')->getClassesDetails();
        $this->_coaches = $this->model('Coaches')->getCoachesDetails();

        parent::__construct($this->_page);

        $this->view($this->_page, $this->_path, [
            'navPages' => $this->_navPages,
            'pageDetails' => $this->_pageDetails,
            'classes' => $this->_classes,
            'coaches' => $this->_coaches
        ]);
    }

    public function index()
    {
        $this->_view->renderView();
    }
}
<?php

class Schedule extends Controller
{
    private $_page;
    private $_schedule;

    public function __construct()
    {
        $this->_page = 'schedule';
        $this->_schedule = $this->model('UpcomingClasses')->getClasses(6);

        parent::__construct($this->_page);


        $this->view($this->_page, $this->_path, [
            'navPages' => $this->_navPages,
            'pageDetails' => $this->_pageDetails,
            'schedule' => $this->_schedule
        ]);
    }

    public function index()
    {
        $this->_view->renderView();
    }

    public function signUp($classId = '')
    {
        echo "Hello {$classId}";
        $this->_view->renderView();
    }
}
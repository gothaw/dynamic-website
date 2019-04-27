<?php

class Schedule extends Controller
{
    private $_page;
    private $_schedule;
    private $_classes;

    public function __construct()
    {
        $this->_page = 'schedule';
        $this->_schedule = $this->model('UpcomingClasses',6);
        $this->_classes = $this->model('Classes',4)->getClassesDetails();

        parent::__construct($this->_page);

        $this->view($this->_page, $this->_path, [
            'navPages' => $this->_navPages,
            'pageDetails' => $this->_pageDetails,
            'schedule' => $this->_schedule->getClassesDetails(),
            'classes' => $this->_classes
        ]);
    }

    public function index()
    {
        $this->_view->renderView();
    }

    public function signUp($classId = '')
    {
        if ($this->_user->isLoggedIn()) {
            trace($this->_classes);


        } else {
            Redirect::to('schedule');
        }
        $this->_view->renderView();
    }
}
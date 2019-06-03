<?php

class AdminSchedule extends Controller
{
    private $_page;
    private $_schedule;

    public function __construct()
    {
        $this->_page = 'admin';
        parent::__construct($this->_page);

        // View instantiated if user is logged in and has admin permissions
        if ($this->_user->isLoggedIn() && $this->_user->hasPermission('admin')) {

            $userData = $this->_user->getData();
            $this->_schedule = $this->model('ScheduledClasses',50);


            $this->view($this->_page, $this->_path, [
                'navPages' => $this->_navPages,
                'pageDetails' => $this->_pageDetails,
                'user' => $userData,
                'schedule' => $this->_schedule->getData()
            ]);
        } else {
            Redirect::to('home');
        }
    }

    public function index($page = '1')
    {
        trace($page);

        $this->_schedule->selectClasses();
        $this->_view->addViewData([

        ]);
        $this->_view->setSubName(toLispCase(__CLASS__));
        $this->_view->renderView();
    }
}
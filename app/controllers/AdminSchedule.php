<?php

class AdminSchedule extends Controller
{
    private $_page;
    private $_schedule;
    private $_lastPage;

    public function __construct()
    {
        $this->_page = 'admin';
        parent::__construct($this->_page);

        // View instantiated if user is logged in and has admin permissions
        if ($this->_user->isLoggedIn() && $this->_user->hasPermission('admin')) {

            $userData = $this->_user->getData();

            $this->_schedule = $this->model('ScheduledClasses', 10);
            $this->_schedule->setNumberOfPages();
            $this->_lastPage = $this->_schedule->getNumberOfPages();

            $this->view($this->_page, $this->_path, [
                'navPages' => $this->_navPages,
                'pageDetails' => $this->_pageDetails,
                'user' => $userData,
                'lastPage' => $this->_lastPage
            ]);
        } else {
            Redirect::to('home');
        }
    }

    public function index($page = '1')
    {
        if ($page < '1' || $page > $this->_lastPage || !is_numeric($page)) {
            $page = '1';
        }
        $this->_schedule->selectClasses($page,true);
        $this->_view->addViewData([
            'schedule' => $this->_schedule->getData(),
            'page' => $page
        ]);
        $this->_view->setSubName(toLispCase(__CLASS__));
        $this->_view->renderView();
    }
}
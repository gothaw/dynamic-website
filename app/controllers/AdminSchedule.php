<?php

class AdminSchedule extends Controller
{
    private $_page;
    private $_schedule;
    private $_lastPage;
    private $_classes;
    private $_coaches;

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

            $this->_classes = $this->model('Classes');
            $this->_classes->selectClasses();

            $this->_coaches = $this->model('Coaches');
            $this->_coaches->selectCoaches();

            $this->view($this->_page, $this->_path, [
                'navPages' => $this->_navPages,
                'pageDetails' => $this->_pageDetails,
                'user' => $userData,
                'classes' => $this->_classes->getData(),
                'coaches' => $this->_coaches->getData(),
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
        $this->_schedule->selectClasses($page, true);
        $this->_view->addViewData([
            'schedule' => $this->_schedule->getData(),
            'page' => $page
        ]);
        $this->_view->setSubName(toLispCase(__CLASS__));
        $this->_view->renderView();
    }

    public function edit($scheduledId = '')
    {
        $selectedClass = $this->_schedule->selectClass($scheduledId);
        if (isset($selectedClass) && is_numeric($scheduledId)) {

            if(Input::exists()){
                if (Token::check(Input::getValue('token'))){
                    trace($_POST);
                }
            }
            $this->_view->addViewData([
                'selectedClass' => $selectedClass
            ]);

        } else {
            Redirect::to('admin-schedule');
        }
        $this->_view->setSubName(toLispCase(__CLASS__) . '/' . __FUNCTION__);
        $this->_view->renderView();
    }

    public function changeSelectedClassDetails()
    {
        if (Input::exists() && is_numeric(Input::getValue('cl_id'))) {
            $selectedClass = $this->_classes->getClass(Input::getValue('cl_id'));
            if (isset($selectedClass)) {
                $returnArray = array('duration' => $selectedClass['cl_duration'], 'no_people' => $selectedClass['cl_max_people']);
                echo json_encode($returnArray);
            }
        } else {
            Redirect::to('admin-schedule');
        }
    }
}
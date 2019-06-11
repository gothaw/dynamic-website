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

            $this->_classes = $this->model('Classes')->selectClasses();

            $this->_coaches = $this->model('Coaches')->selectCoaches();

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
        $scheduledClass = $this->_schedule->selectClass($scheduledId)->getData();

        if (isset($scheduledClass) && is_numeric($scheduledId)) {

            if (Input::exists()) {
                if (Token::check(Input::getValue('token'))) {

                    $validate = new Validate();
                    $validate->check($_POST, ValidationRules::getScheduledClassRules());

                    if ($validate->checkIfPassed()) {

                        $class = $this->_classes->getClass(Input::getValue('class'));
                        $duration = $class['cl_duration'];
                        $maxPeople = $class['cl_max_people'];
                        $startTime = trim(Input::getValue('time'));
                        $date = trim(Input::getValue('date'));


                        if ($this->_schedule->checkIfValidClassTime($date, $startTime, $duration, $scheduledId) && $this->_schedule->validateClassTypeChange($maxPeople, $scheduledId)) {

                            try {

                                // Update scheduled class
                                $this->_schedule->updateScheduledClass($scheduledId, [
                                    'cl_id' => trim(Input::getValue('class')),
                                    'co_id' => trim(Input::getValue('coach')),
                                    'sc_class_date' => $date,
                                    'sc_class_time' => $startTime
                                ]);

                                Session::flash('admin', 'Scheduled class details have been updated.');
                                Redirect::to('admin-schedule');

                            } catch (Exception $e) {
                                $errorMessage = $e->getMessage();
                                $this->_view->setViewError($errorMessage);
                            }

                        } else {
                            // Display schedule error
                            $errorMessage = $this->_schedule->getFirstErrorMessage();
                            $this->_view->setViewError($errorMessage);
                        }
                    } else {
                        // Display a validation error
                        $errorMessage = $validate->getFirstErrorMessage();
                        $this->_view->setViewError($errorMessage);
                    }
                }
            }
            $this->_view->addViewData([
                'scheduledClass' => $scheduledClass
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
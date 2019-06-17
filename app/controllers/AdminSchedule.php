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
        $this->_schedule->selectClasses(false, $page);
        $this->_view->addViewData([
            'schedule' => $this->_schedule->getData(),
            'page' => $page
        ]);
        $this->_view->setSubName(toLispCase(__CLASS__));
        $this->_view->renderView();
    }

    public function edit($scheduledId = '')
    {
        $scheduledClass = $this->_schedule->selectClass($scheduledId, false)->getData();

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

    public function delete($scheduledId = '')
    {
        if (Input::exists()) {
            if (Token::check(Input::getValue('token'))) {

                $scheduledClass = $this->_schedule->selectClass($scheduledId, false)->getData();

                if (isset($scheduledClass) && is_numeric($scheduledId)) {
                    try {
                        // Delete Class
                        $this->_schedule->deleteScheduledClass($scheduledId);
                        Session::flash('admin', 'Scheduled class has been deleted.');
                        Redirect::to('admin-schedule');
                    } catch (Exception $e) {
                        $errorMessage = $e->getMessage();
                        $this->_view->setViewError($errorMessage);
                    }
                }
            }
        }
        $this->_view->addViewData(['itemToBeDeleted' => 'scheduled class']);
        $this->_view->setSubName(toLispCase(__CLASS__) . '/' . __FUNCTION__);
        $this->_view->renderView();
    }

    public function add()
    {
        if (Input::exists()) {
            if (Token::check(Input::getValue('token'))) {

                $validate = new Validate();
                $validate->check($_POST, ValidationRules::getScheduledClassRules());

                if ($validate->checkIfPassed()) {

                    $class = $this->_classes->getClass(Input::getValue('class'));
                    $duration = $class['cl_duration'];
                    $startTime = trim(Input::getValue('time'));
                    $date = trim(Input::getValue('date'));

                    if ($this->_schedule->checkIfValidClassTime($date, $startTime, $duration)) {

                        try {

                            // Add scheduled class
                            $this->_schedule->addScheduledClass([
                                'cl_id' => trim(Input::getValue('class')),
                                'co_id' => trim(Input::getValue('coach')),
                                'sc_no_people' => 0,
                                'sc_class_date' => $date,
                                'sc_class_time' => $startTime
                            ]);

                            Session::flash('admin', 'Class has been scheduled successfully.');
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
        $this->_view->setSubName(toLispCase(__CLASS__) . '/' . __FUNCTION__);
        $this->_view->renderView();
    }

    public function users($scheduledId = '')
    {
        $scheduledClass = $this->_schedule->selectClass($scheduledId, false)->getData();

        if (isset($scheduledClass) && is_numeric($scheduledId)) {

            $users = $this->model('UserClasses')->selectUsers($scheduledId)->getUsersData();

            $this->usersAdd($scheduledId);

            $this->_view->addViewData([
                'scheduledClass' => $scheduledClass,
                'users' => $users
            ]);
        }
        $this->_view->setSubName(toLispCase(__CLASS__) . '/' . __FUNCTION__);
        $this->_view->renderView();
    }

    private function usersAdd($scheduledId)
    {
        if (Input::exists()) {
            if (Token::check(Input::getValue('token'))) {

                $validate = new Validate();
                $validate->check($_POST, ValidationRules::getValidUserIdRules());

                if ($validate->checkIfPassed()) {

                    $userId = trim(Input::getValue('user_id'));
                    $membershipExpiryDate = $this->model('membership', $userId)->getExpiryDate();

                    if ($this->_schedule->checkIfPossibleToSignUp($membershipExpiryDate, $scheduledId)) {

                        $userClasses = $this->model('UserClasses', $userId)->selectClasses(false);

                        if (!$userClasses->checkIfSignedUp($scheduledId)) {

                            try {
                                // Signs user up to the class
                                $userClasses->signUpUserToClass($scheduledId);
                                $this->_schedule->addOnePersonToClass($scheduledId);
                                Session::flash('admin', "You have signed up user to {$this->_schedule->getClassName($scheduledId)} class.");
                                Redirect::to('admin-schedule/users/' . $scheduledId);

                            } catch (Exception $e) {
                                $errorMessage = $e->getMessage();
                                $this->_view->setViewError($errorMessage);
                            }

                        } else {
                            // Display user classes error
                            $errorMessage = $userClasses->getFirstErrorMessage();
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
    }

    public function usersDelete($parameter = '')
    {
        if (Input::exists()) {
            if (Token::check(Input::getValue('token'))) {

                $parameterArray = explode('-', $parameter);

                $scheduledId = $parameterArray[0];
                $userId = $parameterArray[1];

                if (is_numeric($userId) && is_numeric($scheduledId)) {

                    $scheduledClass = $this->_schedule->selectClass($scheduledId, true)->getData();
                    $userClasses = $this->model('UserClasses', $userId)->selectClasses(true);

                    if (isset($scheduledClass) && $userClasses->checkIfSignedUp($scheduledId)) {

                        // User class id from user_class table
                        $userClassId = $userClasses->getUserClassId($scheduledId);

                        try {
                            // Removes user from the class
                            $userClasses->dropUserFromClass($userClassId);
                            $this->_schedule->removeOnePersonFromClass($scheduledId);
                            Session::flash('admin', "You have removed user from {$this->_schedule->getClassName($scheduledId)} class.");
                            Redirect::to('admin-schedule/users/' . $scheduledId);

                        } catch (Exception $e) {
                            $errorMessage = $e->getMessage();
                            $this->_view->setViewError($errorMessage);
                        }
                    }
                }
            }
        }
        $this->_view->addViewData(['itemToBeDeleted' => 'user from the class']);
        $this->_view->setSubName(toLispCase(__CLASS__) . '/' . toLispCase(__FUNCTION__));
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
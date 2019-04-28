<?php

class Schedule extends Controller
{
    private $_page;
    private $_schedule;
    private $_classes;

    public function __construct()
    {
        $this->_page = 'schedule';
        $this->_schedule = $this->model('UpcomingClasses', 7);
        $this->_classes = $this->model('Classes', 4)->getClassesDetails();

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
        // Selects class from a schedule where sc_id == $classId
        $selectedClass = $this->_schedule->selectClass($classId);

        if ($this->_user->isLoggedIn() && $selectedClass && is_numeric($classId)) {

            if ($selectedClass['sc_no_people'] < $selectedClass['cl_max_people']) {

                $userId = $this->_user->getData()['u_id'];

                // Gets classes that user has already signed up to
                $userClasses = $this->model('UserClasses', $userId);

                if ($userClasses->selectClass($classId)) {

                    $errorMessage = "You are already signed up for this class.";
                    $this->_view->setViewError($errorMessage);

                } else {

                    // Signs up user to a class
                    $this->_schedule->addOnePersonToClass($classId);
                    $userClasses->signUpUserToClass($userId, $classId);

                    Session::flash('dashboard', "You have signed up to a {$selectedClass['cl_name']} class.");
                    Redirect::to('dashboard');
                }
            } else {

                // Display an error
                $errorMessage = "Sorry this class is already fully booked. Please select different one.";
                $this->_view->setViewError($errorMessage);
            }
        } else {
            Redirect::to('schedule');
        }
        $this->_view->renderView();
    }
}
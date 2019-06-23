<?php

class Schedule extends Controller
{
    private $_page;
    private $_schedule;
    private $_classes;

    public function __construct()
    {
        $this->_page = 'schedule';
        $this->_schedule = $this->model('ScheduledClasses')->selectClasses(true, 7);

        $this->_classes = $this->model('Classes')->selectClasses(4);

        parent::__construct($this->_page);

        $this->view($this->_page, $this->_path, [
            'navPages' => $this->_navPages,
            'pageDetails' => $this->_pageDetails,
            'schedule' => $this->_schedule->getData(),
            'classes' => $this->_classes->getData()
        ]);
    }

    public function index()
    {
        $this->_view->renderView();
    }

    public function signUp($scheduledId = '')
    {
        if ($this->_user->isLoggedIn() && is_numeric($scheduledId)) {

            $userId = $this->_user->getId();
            $membershipExpiryDate = $this->model('membership', $userId)->getExpiryDate();

            if ($this->_schedule->checkIfPossibleToSignUp($membershipExpiryDate, $scheduledId)) {

                $userClasses = $this->model('UserClasses', $userId)->selectClasses();

                if (!$userClasses->checkIfSignedUp($scheduledId)) {

                    try {
                        // Signs user up to the class
                        $userClasses->signUpUserToClass($scheduledId);
                        $this->_schedule->addOnePersonToClass($scheduledId);
                        Session::flash('dashboard', "You have signed up to {$this->_schedule->getClassName($scheduledId)} class.");
                        Redirect::to('dashboard');

                    } catch (Exception $e) {
                        $errorMessage = $e->getMessage();
                        $this->_view->setViewError($errorMessage);
                    }

                } else {
                    $errorMessage = $userClasses->getFirstErrorMessage();
                    $this->_view->setViewError($errorMessage);
                }

            } else {
                $errorMessage = $this->_schedule->getFirstErrorMessage();
                $this->_view->setViewError($errorMessage);
            }

        } else {
            Redirect::to('schedule');
        }
        $this->_view->renderView();
    }
}
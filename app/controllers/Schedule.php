<?php

class Schedule extends Controller
{
    private $_page;
    private $_schedule;
    private $_classes;

    /**
     *                          Schedule constructor.
     * @desc                    Constructor for schedule page controller. It instantiates database models and selects seven upcoming scheduled classes and four featured classes.
     *                          Instantiates view with schedule, classes, navigation bar and this page data.
     */
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

    /**
     * @method                  index
     * @desc                    Default controller method. Renders scheduled classes page.
     */
    public function index()
    {
        $this->_view->renderView();
    }

    /**
     * @method                  signUp
     * @param                   $scheduledId {string}
     * @desc                    Method handles signing up to upcoming class. Functionality available only for logged in users.
     *                          It uses ScheduledClasses model to validate if user can sign up to the class i.e. membership is not expired, class is not full etc.
     *                          It also checks if user already signed up to the class by using UserClasses model.
     *                          If validation passes it signs user up to the class and adds one person to total number of members that signed up to that scheduled class.
     *                          After signing up successfully it redirects to the dashboard.
     */
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
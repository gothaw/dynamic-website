<?php

class AdminSchedule extends Controller
{
    private $_page;
    private $_schedule;
    private $_classes;
    private $_coaches;

    /**
     *                          AdminSchedule constructor.
     * @desc                    Constructor for admin scheduled classes panel controller. Checks if user is logged in and has admin permission before instantiating view.
     *                          Instantiates classes and coaches models and gets all data for classes and coaches from the database.
     *                          Passes this data to the view along with user, navigation and this page data.
     *                          If user is not logged in or does not have admin permission it redirects to home page.
     */
    public function __construct()
    {
        $this->_page = 'admin';
        parent::__construct($this->_page);

        // View instantiated if user is logged in and has admin permissions
        if ($this->_user->isLoggedIn() && $this->_user->hasPermission('admin')) {

            $userData = $this->_user->getData();

            $this->_schedule = $this->model('ScheduledClasses');

            $this->_classes = $this->model('Classes')->selectClasses();

            $this->_coaches = $this->model('Coaches')->selectCoaches();

            $this->view($this->_page, $this->_path, [
                'navPages' => $this->_navPages,
                'pageDetails' => $this->_pageDetails,
                'user' => $userData,
                'classes' => $this->_classes->getData(),
                'coaches' => $this->_coaches->getData(),
            ]);
        } else {
            Redirect::to('home');
        }
    }

    /**
     * @method                  index
     * @param                   $pageNumber {string}
     * @desc                    Default controller method. Renders main admin schedule panel page. Displays scheduled classes in a table with data for 10 classes per page.
     *                          Invokes selectClasses method for given page number passed as parameter in URL.
     *                          Adds selected classes data to the view along with current page number and last page number.
     */
    public function index($pageNumber = '1')
    {
        $this->_schedule->selectClasses(false, 10, $pageNumber);
        $this->_view->addViewData([
            'schedule' => $this->_schedule->getData(),
            'page' => $this->_schedule->getCurrentPageNumber(),
            'lastPage' => $this->_schedule->getNumberOfPages()
        ]);
        $this->_view->setSubName(toLispCase(__CLASS__));
        $this->_view->renderView();
    }

    /**
     * @method                  add
     * @desc                    Method for adding new scheduled class form page in admin panel. Handles form submission.
     *                          Validates $_POST data using validate object. If validation passes, it checks if selected class duration and start time does not clash with other scheduled class using checkIfValidClassTime method.
     *                          If class time is valid, it adds a new class to the database.
     */
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

    /**
     * @method                  edit
     * @param                   $scheduledId {string}
     * @desc                    Method for editing an existing scheduled class form page in admin panel. It adds data for selected class based on URL parameter to the database.
     *                          Handles form submission. Validates $_POST data using validate object. If validation passes, it checks if selected class duration and start time does not clash with other scheduled class using checkIfValidClassTime method.
     *                          Additionally, it checks if class change is valid that is current number of people does not exceed new max number of people.
     *                          If all validation checks are passed, it edits the scheduled class.
     */
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

    /**
     * @method                  delete
     * @param                   $scheduledId {string}
     * @desc                    Method for deleting scheduled class confirmation page. It handles form submission if user decides to delete the class.
     */
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

    /**
     * @method                  users
     * @param                   $scheduledId {string}
     * @desc                    Method for displaying users that signed up to the selected class. It displays user data in a table.
     *                          Adds selected scheduled class and users data to the view. Invokes usersAdd method if user decides to sign up a new user to selected class.
     */
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
            $this->_view->setSubName(toLispCase(__CLASS__) . '/' . __FUNCTION__);
            $this->_view->renderView();

        } else {
            Redirect::to('admin-schedule');
        }
    }

    /**
     * @method                  usersAdd
     * @param                   $scheduledId {string}
     * @desc                    Private method that handles form submission if user decides to add a new user to a class. Validates $_POST data using validate object.
     *                          If validation passes, it checks if selected user is can sign up to this class i.e class is not full, membership not expired etc.
     *                          Additionally, it checks if user has not sign up to this class already. If all checks are satisfied, it signs user up to the class and increases number of users that sign up to selected class.
     */
    private function usersAdd($scheduledId)
    {
        if (Input::exists()) {
            if (Token::check(Input::getValue('token'))) {

                $validate = new Validate();
                $validate->check($_POST, ValidationRules::getUserIdRules());

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

    /**
     * @method                  usersDelete
     * @param                   $scheduledId {string}
     * @param                   $userId {string}
     * @desc                    Method for removing user from selected class confirmation page. It handles form submission if user decides to do so.
     *                          It validates is user is signed up to this class. If validation passes, it removes user from the class, and decreases number of people that signed up to that class.
     */
    public function usersDelete($scheduledId = '', $userId = '')
    {
        if (Input::exists()) {
            if (Token::check(Input::getValue('token'))) {
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

    /**
     * @method                  changeSelectedClassDetails
     * @desc                    Handles AJAX request from jquery-nice-select.js script for select tag. It changes class duration and max number of people when user changes select tag.
     */
    public function changeSelectedClassDetails()
    {
        if (Input::exists() && is_numeric(Input::getValue('cl_id'))) {
            $selectedClass = $this->_classes->getClass(Input::getValue('cl_id'));
            if (isset($selectedClass)) {
                $returnArray = ['duration' => $selectedClass['cl_duration'], 'no_people' => $selectedClass['cl_max_people']];
                echo json_encode($returnArray);
            }
        } else {
            Redirect::to('admin-schedule');
        }
    }
}
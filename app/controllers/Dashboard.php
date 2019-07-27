<?php

class Dashboard extends Controller
{
    private $_page;
    private $_userData;
    private $_userClasses;
    private $_membership;

    /**
     *                          Dashboard constructor.
     * @desc                    Constructor for user account dashboard.  View is instantiated if user is logged in.
     *                          View is instantiated with user info data such as user personal data, scheduled classes that user signed up to, user membership info and admin permissions.
     */
    public function __construct()
    {
        $this->_page = 'dashboard';
        parent::__construct($this->_page);

        // View instantiated if user is logged in
        if ($this->_user->isLoggedIn()) {

            $this->_userData = $this->_user->getData();
            $this->_userClasses = $this->model('UserClasses', $this->_userData['u_id'])->selectClasses();
            $this->_membership = $this->model('Membership', $this->_userData['u_id']);

            $admin = $this->_user->hasPermission('admin');
            $validMembership = $this->_membership->checkIfValidMembership();

            $this->view($this->_page, $this->_path, [
                'navPages' => $this->_navPages,
                'pageDetails' => $this->_pageDetails,
                'user' => $this->_userData,
                'schedule' => $this->_userClasses->getClassesData(),
                'membership' => $this->_membership->getExpiryDate(),
                'admin' => $admin,
                'validMembership' => $validMembership
            ]);
        } else {
            Redirect::to('home');
        }
    }

    /**
     * @method                  index
     * @desc                    Default controller method. It dashboard page view.
     */
    public function index()
    {
        $this->_view->renderView();
    }

    /**
     * @method                  logout
     * @desc                    Log outs user using User model method and redirects to home page.
     */
    public function logout()
    {
        $this->_user->logoutUser();
        Redirect::to('home');
    }

    /**
     * @method                  edit
     * @desc                    Method for edit user personal details form. It handles form submission. Validates $_POST data using validate object.
     *                          If validation passes, it updates users details using method from parent class - updateUserDetails.
     */
    public function edit()
    {
        if (Input::exists()) {
            if (Token::check(Input::getValue('token'))) {

                // Validation using Validate object
                $validate = new Validate();
                $validate->check($_POST, ValidationRules::getUpdateUserRules());

                if ($validate->checkIfPassed()) {

                    try {
                        // Update User details
                        $this->updateUserDetails($this->_user);
                        Session::flash('dashboard', 'Your details have been updated.');
                        Redirect::to('dashboard');
                    } catch (Exception $e) {
                        $errorMessage = $e->getMessage();
                        $this->_view->setViewError($errorMessage);
                    }

                } else {

                    //Display an Error
                    $errorMessage = $validate->getFirstErrorMessage();
                    $this->_view->setViewError($errorMessage);
                }
            }
        }
        $this->_view->setSubName(__FUNCTION__);
        $this->_view->renderView();
    }

    /**
     * @method                  changePass
     * @desc                    Method for change password form. It handles form submission. Validates $_POST data using validate object.
     *                          It also checks if password provided by user in current password field matches actual password stored in database.
     *                          If password matches and validation passes, it updates password using User model methods updateUser.
     */
    public function changePass()
    {
        if (Input::exists()) {
            if (Token::check(Input::getValue('token'))) {

                // Generates hashed password using salt stored in the database and current password provided in the form
                $currentPasswordProvided = Hash::generateHash(Input::getValue('password_current'), $this->_userData['u_salt']);

                $currentPassword = $this->_userData['u_password'];

                if ($currentPasswordProvided === $currentPassword) {

                    // Validation using Validate object
                    $validate = new Validate();
                    $validate->check($_POST, ValidationRules::getChangePasswordRules());

                    if ($validate->checkIfPassed()) {

                        // Updates password
                        try {
                            $salt = Hash::generateSalt(32);
                            $this->_user->updateUser([
                                'u_password' => Hash::generateHash(Input::getValue('password'), $salt),
                                'u_salt' => $salt
                            ]);
                            Session::flash('dashboard', 'Your password has been changed.');
                            Redirect::to('dashboard');

                        } catch (Exception $e) {
                            $errorMessage = $e->getMessage();
                            $this->_view->setViewError($errorMessage);
                        }
                    } else {

                        //Display an Error
                        $errorMessage = $validate->getFirstErrorMessage();
                        $this->_view->setViewError($errorMessage);
                    }
                } else {

                    $errorMessage = "Your current password is incorrect.";
                    $this->_view->setViewError($errorMessage);
                }
            }
        }
        $this->_view->setSubName(__FUNCTION__);
        $this->_view->renderView();
    }

    /**
     * @method                  drop
     * @param                   $scheduledId {string}
     * @desc                    Method used to drop user from classes that user signed up for. It validates url parameter by checking if user signed up to the class.
     *                          If validation passes it removes class from User Classes and removes one person from total number of members that signed up to that class.
     */
    public function drop($scheduledId = '')
    {
        if (is_numeric($scheduledId)) {

            $schedule = $this->model('ScheduledClasses');
            $scheduledClass = $schedule->selectClass($scheduledId)->getData();

            if (isset($scheduledClass) && $this->_userClasses->checkIfSignedUp($scheduledId)) {

                // User class id from user_class table
                $userClassId = $this->_userClasses->getUserClassId($scheduledId);

                try {
                    // Removes user from the class
                    $this->_userClasses->dropUserFromClass($userClassId);
                    $schedule->removeOnePersonFromClass($scheduledId);
                    Session::flash('dashboard', "You have dropped out from {$schedule->getClassName($scheduledId)} class.");
                    Redirect::to('dashboard');

                } catch (Exception $e) {
                    $errorMessage = $e->getMessage();
                    $this->_view->setViewError($errorMessage);
                }
            }

        } else {
            Redirect::to('dashboard');
        }
        $this->_view->renderView();
    }

    /**
     * @method                  membership
     * @desc                    Method for renew membership form. Form submission handled by PayPal API.
     */
    public function membership()
    {
        $this->_view->setSubName(__FUNCTION__);
        $this->_view->renderView();
    }
}
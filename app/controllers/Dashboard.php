<?php

class Dashboard extends Controller
{
    private $_page;
    private $_userData;
    private $_userClasses;
    private $_membership;

    public function __construct()
    {
        $this->_page = 'dashboard';
        parent::__construct($this->_page);

        // View instantiated if user is logged in
        if ($this->_user->isLoggedIn()) {

            $this->_userData = $this->_user->getData();
            $this->_userClasses = $this->model('UserClasses', $this->_userData['u_id']);
            $this->_membership = $this->model('Membership', $this->_userData['u_id']);

            $admin = $this->_user->hasPermission('admin');
            $validMembership = $this->_membership->checkIfValidMembership();

            $this->view($this->_page, $this->_path, [
                'navPages' => $this->_navPages,
                'pageDetails' => $this->_pageDetails,
                'user' => $this->_userData,
                'schedule' => $this->_userClasses->getData(),
                'membership' => $this->_membership->getExpiryDate(),
                'admin' => $admin,
                'validMembership' => $validMembership
            ]);
        } else {
            Redirect::to('home');
        }
    }

    public function index()
    {
        $this->_view->renderView();
    }

    public function logout()
    {
        $this->_user->logoutUser();
        Redirect::to('home');
    }

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

    public function drop($classId = '')
    {
        if (is_numeric($classId)) {

            if ($this->_userClasses->checkIfSignedUp($classId)) {

                // User class id from user_class table
                $userClassId = $this->_userClasses->getUserClassId($classId);
                $schedule = $this->model('UpcomingClasses');

                try{
                    // Removes user from the class
                    $this->_userClasses->dropUserFromClass($userClassId);
                    $schedule->removeOnePersonFromClass($classId);
                    Session::flash('dashboard', "You have dropped out from {$schedule->getClassName($classId)} class.");
                    Redirect::to('dashboard');

                } catch (Exception $e){
                    $errorMessage = $e->getMessage();
                    $this->_view->setViewError($errorMessage);
                }

            } else {
                Redirect::to('dashboard');
            }
        }
        $this->_view->renderView();
    }

    public function membership()
    {
        $this->_view->setSubName(__FUNCTION__);
        $this->_view->renderView();
    }
}
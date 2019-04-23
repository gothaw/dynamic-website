<?php

class Dashboard extends Controller
{
    private $_page;

    public function __construct()
    {
        $this->_page = 'dashboard';
        parent::__construct($this->_page);

        // View instantiated if user is logged in
        if ($this->_user->isLoggedIn()) {

            $userData = $this->_user->getData();

            $this->view($this->_page, $this->_path, [
                'navPages' => $this->_navPages,
                'pageDetails' => $this->_pageDetails,
                'user' => $userData
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

                    // Update User Details
                    try {
                        $this->_user->updateUser([
                            'u_first_name' => Input::getValue('first_name'),
                            'u_last_name' => Input::getValue('last_name'),
                            'u_address_1' => Input::getValue('address_first_line'),
                            'u_address_2' => Input::getValue('address_second_line'),
                            'u_postcode' => Input::getValue('postcode'),
                            'u_city' => Input::getValue('city'),
                            'u_email' => Input::getValue('email'),
                        ]);
                    } catch (Exception $e) {
                        $errorMessage = $e->getMessage();
                        $this->_view->setViewError($errorMessage);
                    }
                    Session::flash('dashboard', 'Your details have been updated.');
                    Redirect::to('dashboard');
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

                // Validation using Validate object
                $validate = new Validate();
                $validate->check($_POST, ValidationRules::getChangePasswordRules());

                if ($validate->checkIfPassed()) {

                    // Generates hashed password using salt stored in the database and current password provided in the form
                    $currentPasswordProvided = Hash::generateHash(Input::getValue('password_current'), $this->_user->getData()['u_salt']);

                    $currentPassword = $this->_user->getData()['u_password'];

                    if ($currentPasswordProvided === $currentPassword) {

                        // Updates password
                        try{
                            $salt = Hash::generateSalt(32);
                            $this->_user->updateUser([
                                'u_password' => Hash::generateHash(Input::getValue('password'), $salt),
                                'u_salt' => $salt
                            ]);
                        } catch (Exception $e) {
                            $errorMessage = $e->getMessage();
                            $this->_view->setViewError($errorMessage);
                        }
                        Session::flash('dashboard', 'Your password has been changed.');
                        Redirect::to('dashboard');

                    } else {

                        $errorMessage = "Your current password is incorrect.";
                        $this->_view->setViewError($errorMessage);
                    }
                    Session::flash('dashboard', 'Your details have been updated.');
                    Redirect::to('dashboard');

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
}
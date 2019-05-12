<?php

class Register extends Controller
{
    private $_page;

    public function __construct()
    {
        $this->_page = 'register';

        parent::__construct($this->_page);

        // View is instantiated if user not logged in
        if (!$this->_user->isLoggedIn()) {
            $this->view($this->_page, $this->_path, [
                'navPages' => $this->_navPages,
                'pageDetails' => $this->_pageDetails
            ]);
        } else {
            Redirect::to('home');
        }
    }

    public function index()
    {
        if (Input::exists()) {
            if (Token::check(Input::getValue('token'))) {

                // Validation using Validate object
                $validate = new Validate();
                $validate->check($_POST, ValidationRules::getRegisterUserRules());

                if ($validate->checkIfPassed()) {

                    // Register a User
                    $user = $this->model('User');

                    try {
                        $salt = Hash::generateSalt(32);
                        $user->createUser([
                            'u_first_name' => trim(Input::getValue('first_name')),
                            'u_last_name' => trim(Input::getValue('last_name')),
                            'u_address_1' => trim(Input::getValue('address_first_line')),
                            'u_address_2' => trim(Input::getValue('address_second_line')),
                            'u_postcode' => trim(Input::getValue('postcode')),
                            'u_city' => trim(Input::getValue('city')),
                            'u_username' => trim(Input::getValue('username')),
                            'u_email' => trim(Input::getValue('email')),
                            'u_password' => Hash::generateHash(Input::getValue('password'), $salt),
                            'u_salt' => $salt,
                            'u_group_id' => 1,
                            'u_joined' => date('Y-m-d H-i-s')
                        ]);
                        Session::flash('home', 'You have been register you can now log in.');
                        Redirect::to('home');
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
        $this->_view->renderView();
    }
}
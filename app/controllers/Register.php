<?php

class Register extends Controller
{
    private $_page;

    public function __construct()
    {
        $this->_page = 'register';

        parent::__construct($this->_page);

        $this->view($this->_page, $this->_path, [
            'navPages' => $this->_navPages,
            'pageDetails' => $this->_pageDetails
        ]);
    }

    public function index()
    {
        $this->_view->renderView();
    }

    public function form()
    {
        if (Input::exists()) {
            if (Token::check(Input::get('token'))) {

                // Validation using Validate object
                $validate = new Validate();
                $validate->check($_POST, $validate->getValidUserRules());

                if ($validate->checkIfPassed()) {

                    // Register a User
                    $user = $this->model('User');
                    try{
                        $user->createUser([
                            'u_first_name' => '',
                            'u_last_name' => '',
                            'u_address_1' => '',
                            'u_address_2' => '',
                            'u_postcode' => '',
                            'u_city' => '',
                            'u_username' => '',
                            'u_email' => '',
                            'u_password' => '',
                            'u_salt' => '',
                            'u_group_id' => '',
                            'u_joined' => ''
                        ]);
                        Session::flash('home', 'You have been register you can now log in.');
                        Redirect::to('home');
                    }
                    catch (Exception $e){
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
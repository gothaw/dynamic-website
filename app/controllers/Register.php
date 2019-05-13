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
                        $this->insertUserDetails($user);
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
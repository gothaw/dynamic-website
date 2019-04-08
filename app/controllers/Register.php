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

                    Session::flash('home', 'You have been register you can now log in.');
                    Redirect::to('home');

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
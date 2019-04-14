<?php

class Login extends Controller
{
    private $_page;

    public function __construct()
    {
        $this->_page = 'login';

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
            if (Token::check(Input::getValue('token'))) {

                // Validation using Validate object
                $validate = new Validate();
                $validate->check($_POST, ValidationRules::getValidLoginRules());

                if ($validate->checkIfPassed()) {

                    // Log user in
                    $user = $this->model('User');
                    $login = $user->loginUser(Input::getValue('username'), Input::getValue('password'));

                    if($login){

                        Redirect::to('home');

                    } else{

                        $errorMessage = 'Sorry username or password are incorrect.';
                        $this->_view->setViewError($errorMessage);

                    }
                } else {

                    // Display an Error
                    $errorMessage = $validate->getFirstErrorMessage();
                    $this->_view->setViewError($errorMessage);

                }
            }
        }
        $this->_view->renderView();
    }
}
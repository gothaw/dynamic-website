<?php

class Login extends Controller
{
    private $_page;

    public function __construct()
    {
        $this->_page = 'login';

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
                $validate->check($_POST, ValidationRules::getLoginRules());

                if ($validate->checkIfPassed()) {

                    // Log user in
                    $user = $this->model('User');

                    $rememberUser = (Input::getValue('remember') === 'on') ? true : false;

                    $login = $user->loginUser(trim(Input::getValue('username')), Input::getValue('password'), $rememberUser);

                    if ($login) {
                        // Successful login
                        Redirect::to('dashboard');
                    } else {
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
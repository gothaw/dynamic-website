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
            $this->view($this->_page, $this->_path, [
                'navPages' => $this->_navPages,
                'pageDetails' => $this->_pageDetails
            ]);
        }
        else{
            Redirect::to('home');
        }
    }

    public function index()
    {
        $this->_view->renderView();
    }

    public function logout()
    {
        echo "Logging out";
    }
}
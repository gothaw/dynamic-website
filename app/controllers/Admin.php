<?php

/**
 *                              Class Admin
 * @desc                        Controller for Admin panel menu page.
 */
class Admin extends Controller
{
    private $_page;

    /**
     *                          Admin constructor.
     * @desc                    Constructor for admin dashboard page controller. Checks if user is logged in and has admin permission before instantiating view.
     *                          Instantiates view with user, navigation bar and this page data.
     *                          If user is not logged in or does not have admin permission it redirects to home page.
     */
    public function __construct()
    {
        $this->_page = 'admin';
        parent::__construct($this->_page);

        // View instantiated if user is logged in and has admin permissions
        if ($this->_user->isLoggedIn() && $this->_user->hasPermission('admin')) {

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

    /**
     * @method                  index
     * @desc                    Default controller method. Renders admin panel page view.
     */
    public function index()
    {
        $this->_view->renderView();
    }
}


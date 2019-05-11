<?php

class Controller
{
    protected $_view;
    protected $_model;
    protected $_navPages;
    protected $_pageDetails;
    protected $_path;
    protected $_user;

    /**
     *                      Controller constructor.
     * @param               $page {page name as a string}
     * @desc                Initializes fields that are common for all controllers such as current page details, navigation bar pages and user field.
     */
    public function __construct($page)
    {
        $this->_navPages = $this->model('NavBarPages')->getData();
        $currentPage = $this->model('CurrentPage', $page);
        $this->_pageDetails = $currentPage->getData();
        $this->_path = $currentPage->getPageUrl();
        $this->_user = $this->model('User');
    }

    /**
     * @method              model
     * @param               $model {model file name in models folder e.g for user 'User'}
     * @param               $parameter {parameter passed to model e.g. user id}
     * @desc                Creates a new model with an optional parameter.
     * @return              mixed|null
     */
    protected function model($model, $parameter = null)
    {
        if (file_exists('../app/models/' . $model . '.php')) {
            require_once '../app/models/' . $model . '.php';

            $this->_model = new $model($parameter);
            return $this->_model;
        }
        return null;
    }

    /**
     * @method              view
     * @param               $viewName {string}
     * @param               $view {path to index.php file in views folder e.g. for home page 'home/'}
     * @param               $data {data passed to the view as an array}
     * @desc                Creates a new view and assigns it to _view field.
     *                      It also sets the field in view that describes if user is logged in.
     */
    protected function view($viewName, $view, $data = [])
    {
        if (file_exists('../app/views/' . $view . '/index.php')) {
            $this->_view = new View($viewName, $view, $data);
            $this->_view->setUserIsLoggedIn($this->_user->isLoggedIn());
        }
    }

    /**
     * @method              userSearch
     * @desc                Method handles functionality of user search bar in members and membership admin panel.
     *                      It gets data using UserSearch model and adds it to the view.
     */
    protected function userSearch()
    {
        if (Input::exists()) {
            if (Token::check(Input::getValue('token'))) {
                $userSearch = $this->model('UserSearch', trim(Input::getValue('search')))->getData();
                $this->_view->addViewData(['search' => $userSearch]);
            }
        }
    }

    /**
     * @method              updateUserDetails
     * @param               $user {object}
     * @param               $id {user id}
     * @desc                Method updates user details. Used in dashboard and admin panel.
     */
    protected function updateUserDetails($user, $id = null)
    {
        // Update User Details
        $user->updateUser([
            'u_first_name' => trim(Input::getValue('first_name')),
            'u_last_name' => trim(Input::getValue('last_name')),
            'u_address_1' => trim(Input::getValue('address_first_line')),
            'u_address_2' => trim(Input::getValue('address_second_line')),
            'u_postcode' => trim(Input::getValue('postcode')),
            'u_city' => trim(Input::getValue('city'))
        ], $id);
    }
}
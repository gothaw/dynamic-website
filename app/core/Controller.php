<?php

class Controller
{
    protected $_view;
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
        $this->_navPages = $this->model('NavBarPages')->getNavBarPages();
        $currentPage = $this->model('CurrentPage', $page);
        $this->_pageDetails = $currentPage->getPageDetails();
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
    public function model($model, $parameter = null)
    {
        if (file_exists('../app/models/' . $model . '.php')) {
            require_once '../app/models/' . $model . '.php';
            return new $model($parameter);
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
    public function view($viewName, $view, $data = [])
    {
        if (file_exists('../app/views/' . $view . 'index.php')) {
            $this->_view = new View($viewName, $view, $data);
            $this->_view->setUserIsLoggedIn($this->_user->isLoggedIn());
        }
    }
}
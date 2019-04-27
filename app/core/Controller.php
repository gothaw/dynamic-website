<?php

class Controller
{
    protected $_view        = null;
    protected $_navPages    = null;
    protected $_pageDetails = null;
    protected $_path        = null;
    protected $_user        = null;

    public function __construct($page)
    {
        $this->_navPages = $this->model('NavBarPages')->getNavBarPages();
        $currentPage = $this->model('CurrentPage', $page);
        $this->_pageDetails = $currentPage->getPageDetails();
        $this->_path = $currentPage->getPageUrl();
        $this->_user = $this->model('User');
    }

    public function model($model, $parameter = null)
    {
        if (file_exists('../app/models/' . $model . '.php')) {
            require_once '../app/models/' . $model . '.php';
            return new $model($parameter);
        }
        return null;
    }

    public function view($viewName, $view, $data = [])
    {
        if (file_exists('../app/views/' . $view . 'index.php')) {
            $this->_view = new View($viewName, $view, $data);
            $this->_view->setUserIsLoggedIn($this->_user->isLoggedIn());
        }
    }
}
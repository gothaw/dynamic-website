<?php

class AdminClasses extends Controller
{
    private $_page;
    private $_classes;

    public function __construct()
    {
        $this->_page = 'admin';
        parent::__construct($this->_page);

        // View instantiated if user is logged in and has admin permissions
        if ($this->_user->isLoggedIn() && $this->_user->hasPermission('admin')) {

            $userData = $this->_user->getData();
            $this->_classes = $this->model('Classes');
            $this->_classes->selectClasses();

            $this->view($this->_page, $this->_path, [
                'navPages' => $this->_navPages,
                'pageDetails' => $this->_pageDetails,
                'user' => $userData,
                'classes' => $this->_classes->getData()
            ]);
        } else {
            Redirect::to('home');
        }
    }

    public function index()
    {
        $this->_view->setSubName(toLispCase(__CLASS__));
        $this->_view->renderView();
    }

    public function edit($classId = '')
    {
        $selectedClass = $this->_classes->getClass($classId);
        if (isset($selectedClass) && is_numeric($classId)) {

            if(Input::exists()){
                echo 'ok';
            }

            $this->_view->addViewData(['selectedClass' => $selectedClass]);
        } else{
            Redirect::to('admin-classes');
        }
        $this->_view->setSubName(toLispCase(__CLASS__) . '/' . __FUNCTION__);
        $this->_view->renderView();
    }
}
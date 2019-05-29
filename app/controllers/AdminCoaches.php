<?php

class AdminCoaches extends Controller
{
    private $_page;
    private $_coaches;

    public function __construct()
    {
        $this->_page = 'admin';
        parent::__construct($this->_page);

        // View instantiated if user is logged in and has admin permissions
        if ($this->_user->isLoggedIn() && $this->_user->hasPermission('admin')) {

            $userData = $this->_user->getData();
            $this->_coaches = $this->model('Coaches');
            $this->_coaches->selectCoaches();

            $this->view($this->_page, $this->_path, [
                'navPages' => $this->_navPages,
                'pageDetails' => $this->_pageDetails,
                'user' => $userData,
                'coaches' => $this->_coaches->getData()
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

    public function edit($coachId = '')
    {
        $selectedCoach = $this->_coaches->getCoach($coachId);

        if (isset($selectedCoach) && is_numeric($coachId)){
            if (Input::exists()) {
                if (Token::check(Input::getValue('token'))) {

                    // Validation using Validate object
                    $validate = new Validate();
                    $validate->check($_POST, ValidationRules::getValidCoachRules());

                    // Create new File
                    $image = new File('class_image');

                    if ($validate->checkIfPassed()) {
                        if (!$image->exists() || $image->checkIfValid(500, ['jpg', 'jpeg', 'png', 'giff'])) {

                            try {

                                trace($_POST);
                                trace($_FILES);

                            } catch (Exception $e) {
                                $errorMessage = $e->getMessage();
                                $this->_view->setViewError($errorMessage);
                            }

                        } else {
                            // Display file validation error
                            $errorMessage = $image->getError();
                            $this->_view->setViewError($errorMessage);
                        }
                    } else {
                        // Display validation error
                        $errorMessage = $validate->getFirstErrorMessage();
                        $this->_view->setViewError($errorMessage);
                    }
                }
            }
            $this->_view->addViewData(['selectedCoach' => $selectedCoach]);
        } else {
            Redirect::to('admin-coaches');
        }
        $this->_view->setSubName(toLispCase(__CLASS__) . '/' . __FUNCTION__);
        $this->_view->renderView();
    }

    public function delete($coachId = '')
    {
        $this->_view->addViewData(['itemToBeDeleted' => 'coach']);
        $this->_view->setSubName(toLispCase(__CLASS__) . '/' . __FUNCTION__);
        $this->_view->renderView();
    }

    public function add()
    {
        $this->_view->setSubName(toLispCase(__CLASS__) . '/' . __FUNCTION__);
        $this->_view->renderView();
    }
}
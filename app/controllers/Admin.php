<?php

class Admin extends Controller
{
    private $_page;

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

    public function index()
    {
        $this->_view->renderView();
    }

    public function membership()
    {
        if (Input::exists()) {
            if (Token::check(Input::getValue('token'))) {
                $userSearch = $this->model('UserSearch', trim(Input::getValue('search')))->getUserData();
                $this->_view->addViewData(['search' => $userSearch]);
            }
        }
        $this->_view->setSubName(__FUNCTION__);
        $this->_view->renderView();
    }

    public function editMembership($userId = '')
    {
        $selectedUser = $this->model('User', $userId)->getData();

        if (isset($selectedUser) && is_numeric($userId)) {

            $userMembership = $this->model('Membership', $userId);
            $expiryDate = $userMembership->getExpiryDate();

            if (Input::exists()) {
                if (Token::check(Input::getValue('token'))) {

                    // Validation using Validate object
                    $validate = new Validate();
                    $validate->check($_POST, ValidationRules::getValidDateRules());

                    if ($validate->checkIfPassed()) {

                        // Update membership
                        $userMembership->updateMembership($userId, Input::getValue('date'));
                        Session::flash('admin', 'User membership has been updated.');
                        Redirect::to('admin/membership');

                    } else {

                        //Display an Error
                        $errorMessage = $validate->getFirstErrorMessage();
                        $this->_view->setViewError($errorMessage);
                    }
                }
            }

            $this->_view->addViewData([
                'selectedUser' => $selectedUser,
                'expiryDate' => $expiryDate
            ]);

        } else {
            Redirect::to('admin/membership');
        }
        $this->_view->setSubName(__FUNCTION__);
        $this->_view->renderView();
    }
}


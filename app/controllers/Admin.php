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
        $this->userSearch();
        $this->_view->setSubName(__FUNCTION__);
        $this->_view->renderView();
    }

    public function editMembership($userId = '')
    {
        $selectedUser = $this->model('User', $userId);

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
                'selectedUser' => $selectedUser->getData(),
                'expiryDate' => $expiryDate
            ]);

        } else {
            Redirect::to('admin/membership');
        }

        $this->_view->setSubName(__FUNCTION__);
        $this->_view->renderView();
    }

    public function cancelMembership($userId = '')
    {
        $membership = $this->model('Membership', $userId);
        $expiryDate = $membership->getExpiryDate();

        if (isset($expiryDate) && is_numeric($userId)) {

            $membership->cancelMembership($userId);
            Session::flash('admin', 'User membership has been cancelled.');
            Redirect::to('admin/membership/');

        } else {
            Redirect::to('admin/membership/');
        }

        $this->_view->renderView();
    }

    public function members()
    {
        $this->userSearch();
        $this->_view->setSubName(__FUNCTION__);
        $this->_view->renderView();
    }

    public function editUser($userId = '')
    {
        $selectedUser = $this->model('User', $userId);
        $selectedUserData = $selectedUser->getData();

        if (isset($selectedUser) && is_numeric($userId)) {

            $userGroups = $this->model('UserGroups')->getUserGroupsDetails();

            if (Input::exists()) {
                if (Token::check(Input::getValue('token'))) {

                    // Validation using Validate object
                    $validate = new Validate();
                    $validate->check($_POST, ValidationRules::getUpdateUserRules());

                    if ($validate->checkIfPassed()) {

                        $this->updateUser($selectedUser, 'admin/members', 'admin', ucfirst($selectedUserData['u_username']) . ' details have been updated.', $userId);

                    } else {

                        //Display an Error
                        $errorMessage = $validate->getFirstErrorMessage();
                        $this->_view->setViewError($errorMessage);
                    }
                }
            }

            $this->_view->addViewData([
                'selectedUser' => $selectedUserData,
                'userGroups' => $userGroups
            ]);

        } else {
            Redirect::to('admin/members');
        }

        $this->_view->setSubName(__FUNCTION__);
        $this->_view->renderView();
    }

    public function deleteUser($userId = '')
    {

        var_dump($userId);

        if (is_numeric($userId)) {

            echo "It is numeric";

        }

        $this->_view->setSubName(__FUNCTION__);
        $this->_view->renderView();
    }
}


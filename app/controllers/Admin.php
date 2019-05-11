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
        if (is_numeric($userId)) {

            $selectedUser = $this->model('User', $userId);

            if (isset($selectedUser)) {

                $userMembership = $this->model('Membership', $userId);
                $expiryDate = $userMembership->getExpiryDate();

                if (Input::exists()) {
                    if (Token::check(Input::getValue('token'))) {

                        // Validation using Validate object
                        $validate = new Validate();
                        $validate->check($_POST, ValidationRules::getValidDateRules());

                        if ($validate->checkIfPassed()) {
                            try {
                                // Update Membership
                                $userMembership->updateMembership($userId, Input::getValue('date'));
                                Session::flash('admin', 'User membership has been updated.');
                                Redirect::to('admin/membership');

                            } catch (Exception $e) {
                                $errorMessage = $e->getMessage();
                                $this->_view->setViewError($errorMessage);
                            }
                        } else {
                            // Display an Error
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
        }
        $this->_view->setSubName(__FUNCTION__);
        $this->_view->renderView();
    }

    public function cancelMembership($userId = '')
    {
        if (is_numeric($userId)) {

            $membership = $this->model('Membership', $userId);
            $expiryDate = $membership->getExpiryDate();

            if (isset($expiryDate)) {

                $membership->cancelMembership($userId);
                Session::flash('admin', 'User membership has been cancelled.');
                Redirect::to('admin/membership');

            } else {
                Redirect::to('admin/membership');
            }
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

        if (is_numeric($userId) && isset($selectedUser)) {

            $selectedUserData = $selectedUser->getData();

            $userGroups = $this->model('UserGroups');
            $userGroupsData = $userGroups->getData();

            if (Input::exists()) {
                if (Token::check(Input::getValue('token'))) {

                    // Validation using Validate object
                    $validate = new Validate();
                    $validate->check($_POST, ValidationRules::getUpdateUserRulesAdminPanel());

                    if ($validate->checkIfPassed()) {

                        try {

                            // Updated User details
                            $this->updateUserDetails($selectedUser, $userId);

                            // Update User permissions
                            $groupId = $userGroups->getIdForGroupName(trim(Input::getValue('permission')));
                            $selectedUser->updateUser([
                                'u_group_id' => $groupId,
                            ], $userId);

                            Session::flash('admin', ucfirst($selectedUserData['u_username']) . ' details have been updated.');
                            Redirect::to('admin/members');

                        } catch (Exception $e) {
                            $errorMessage = $e->getMessage();
                            $this->_view->setViewError($errorMessage);
                        }

                    } else {

                        //Display an Error
                        $errorMessage = $validate->getFirstErrorMessage();
                        $this->_view->setViewError($errorMessage);
                    }
                }
            }

            $this->_view->addViewData([
                'selectedUser' => $selectedUserData,
                'userGroups' => $userGroupsData
            ]);

        } else {
            Redirect::to('admin/members');
        }
        $this->_view->setSubName(__FUNCTION__);
        $this->_view->renderView();
    }

    public function deleteUser($userId = '')
    {
        if (is_numeric($userId)) {

            echo "It is numeric";

        }
        $this->_view->setSubName(__FUNCTION__);
        $this->_view->renderView();
    }
}


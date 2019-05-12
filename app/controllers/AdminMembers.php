<?php

class AdminMembers extends Controller
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
        $this->userSearch();
        $this->_view->setSubName(toLispCase(__CLASS__));
        $this->_view->renderView();
    }

    public function edit($userId = '')
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
                            Redirect::to('admin-members');

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
            Redirect::to('admin-members');
        }
        $this->_view->setSubName(toLispCase(__CLASS__) . '/' . __FUNCTION__);
        $this->_view->renderView();
    }

    public function delete($userId = '')
    {
        $selectedUser = $this->model('User', $userId);

        if (is_numeric($userId) && isset($selectedUser)) {

            $selectedUserData = $selectedUser->getData();

            try {
                // Deletes User
                $selectedUser->deleteUser($userId);
                Session::flash('admin', ucfirst($selectedUserData['u_username']) . ' has been deleted.');
                Redirect::to('admin-members');
            } catch (Exception $e) {
                // Display an Error
                $errorMessage = $e->getMessage();
                $this->_view->setViewError($errorMessage);
            }

        } else {
            Redirect::to('admin-members');
        }
        $this->_view->renderView();
    }
}
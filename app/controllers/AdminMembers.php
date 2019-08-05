<?php

class AdminMembers extends Controller
{
    private $_page;

    /**
     *                          AdminMembers constructor.
     * @desc                    Constructor for admin members panel controller. Checks if user is logged in and has admin permission before instantiating view.
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
     * @desc                    Default controller method. Renders admin panel - member area. It invokes userSearch method from the parent.
     */
    public function index()
    {
        $this->userSearch();
        $this->_view->setSubName(toLispCase(__CLASS__));
        $this->_view->renderView();
    }

    /**
     * @method                  add
     * @desc                    Method for adding a new user in admin panel. It adds user groups data to the view.
     *                          It handles form submission. Validates $_POST data using validate object.
     *                          If validation passes, it instantiates user object and gets user group name from form submission.
     *                          It registers the user with given data.
     */
    public function add()
    {
        // Gets User Groups Data
        $userGroups = $this->model('UserGroups');
        $userGroupsData = $userGroups->getData();

        if (Input::exists()) {
            if (Token::check(Input::getValue('token'))) {

                // Validation using Validate object
                $validate = new Validate();
                $validate->check($_POST, ValidationRules::getRegisterUserRulesAdminPanel());

                if ($validate->checkIfPassed()) {

                    // Register a User
                    $user = $this->model('User');
                    $groupId = trim(Input::getValue('permission'));

                    try {

                        $this->insertUserDetails($user, $groupId);
                        Session::flash('admin', 'You have registered a new gym member.');
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
            'userGroups' => $userGroupsData
        ]);
        $this->_view->setSubName(toLispCase(__CLASS__) . '/' . __FUNCTION__);
        $this->_view->renderView();
    }

    /**
     * @method                  edit
     * @param                   $userId {string}
     * @desc                    Method for editing selected user data in admin panel. It adds user groups and selected user data to the view.
     *                          It handles form submission. Validates $_POST data using validate object. If validation passes, it updates details by invoking updateUserDetails method from the parent.
     *                          It also updates user permissions using updateUser.
     */
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
                            $groupId = trim(Input::getValue('permission'));
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

    /**
     * @method                  delete
     * @param                   $userId {string}
     * @desc                    Method for deleting selected user confirmation page. It handles form submission if user decides to delete selected user.
     *                          It instantiates Membership, UserClasses and Scheduled Classes models. Deletes user membership and all user classes.
     *                          If user signed up to a future scheduled class, it reduces number of people that signed up to that class by one.
     *                          After carrying out these delete and update queries, it deletes the user from the database.
     */
    public function delete($userId = '')
    {
        if (Input::exists()) {
            if (Token::check(Input::getValue('token'))) {

                $selectedUser = $this->model('User', $userId);

                if (is_numeric($userId) && isset($selectedUser)) {

                    // User Data
                    $selectedUserData = $selectedUser->getData();

                    // Instantiate User Membership model
                    $membership = $this->model('Membership', $userId);

                    // Instantiate User Classes model and select future classes
                    $userClasses = $this->model('UserClasses', $userId)->selectClasses();
                    $userClassesData = $userClasses->getClassesData();

                    // Instantiate Scheduled Classes model and select future classes
                    $schedule = $this->model('ScheduledClasses')->selectClasses();

                    try {

                        // Delete membership
                        $membership->cancelMembership($userId);
                        // Delete users classes
                        $userClasses->deleteClassesForSelectedUser();
                        // Reduces number of people on future classes by 1.
                        foreach ($userClassesData as $class) {
                            $schedule->removeOnePersonFromClass($class['sc_id']);
                        }
                        // Delete user
                        $selectedUser->deleteUser($userId);
                        Session::flash('admin', 'User ' . $selectedUserData['u_username'] . ' has been deleted.');
                        Redirect::to('admin-members');

                    } catch (Exception $e) {
                        // Display an Error
                        $errorMessage = $e->getMessage();
                        $this->_view->setViewError($errorMessage);
                    }
                }
            }
        }
        $this->_view->addViewData(['itemToBeDeleted' => 'user']);
        $this->_view->setSubName(toLispCase(__CLASS__) . '/' . __FUNCTION__);
        $this->_view->renderView();
    }
}
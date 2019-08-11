<?php

/**
 *                              Class AdminMembership
 * @desc                        Controller for admin panel membership area. Includes methods to edit and cancel user membership.
 */
class AdminMembership extends Controller
{
    private $_page;

    /**
     *                          AdminMembership constructor.
     * @desc                    Constructor for admin membership panel controller. Checks if user is logged in and has admin permission before instantiating view.
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
     *                          index
     * @desc                    Default controller method. Renders admin panel - membership area. It invokes userSearch method from the parent.
     */
    public function index()
    {
        $this->userSearch();
        $this->_view->setSubName(toLispCase(__CLASS__));
        $this->_view->renderView();
    }

    /**
     * @method                  edit
     * @param                   $userId {string}
     * @desc                    Method for editing user's membership in admin panel. It adds user and user's membership data to the view.
     *                          It handles form submission. Validates $_POST data using validate object. If validation passes it updates user's membership
     */
    public function edit($userId = '')
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
                        $validate->check($_POST, ValidationRules::getFutureDateRules());

                        if ($validate->checkIfPassed()) {
                            try {
                                // Update Membership
                                $userMembership->updateMembership(Input::getValue('date'));
                                Session::flash('admin', 'User membership has been updated.');
                                Redirect::to('admin-membership');

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
                Redirect::to('admin-membership');
            }
        }
        $this->_view->setSubName(toLispCase(__CLASS__) . '/' . __FUNCTION__);
        $this->_view->renderView();
    }

    /**
     * @method                  cancel
     * @param                   $userId {string}
     * @desc                    Method for canceling user's membership confirmation page. It handles form submission if user decides to cancel user's membership.
     */
    public function cancel($userId = '')
    {
        if(Input::exists()){
            if (Token::check(Input::getValue('token')) && is_numeric($userId)) {

                $membership = $this->model('Membership', $userId);
                $expiryDate = $membership->getExpiryDate();

                if (isset($expiryDate)) {
                    try {
                        // Cancel membership
                        $membership->cancelMembership();
                        Session::flash('admin', 'User membership has been cancelled.');
                        Redirect::to('admin-membership');
                    } catch (Exception $e) {
                        $errorMessage = $e->getMessage();
                        $this->_view->setViewError($errorMessage);
                    }
                }
            }
        }
        $this->_view->addViewData(['itemToBeDeleted' => 'membership']);
        $this->_view->setSubName(toLispCase(__CLASS__) . '/' . __FUNCTION__);
        $this->_view->renderView();
    }

}
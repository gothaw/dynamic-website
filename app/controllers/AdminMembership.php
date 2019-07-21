<?php

class AdminMembership extends Controller
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
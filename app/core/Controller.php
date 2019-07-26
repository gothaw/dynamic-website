<?php

class Controller
{
    protected $_view;
    protected $_navPages;
    protected $_pageDetails;
    protected $_path;
    protected $_user;

    /**
     *                      Controller constructor.
     * @param               $page {page name as a string}
     * @desc                Initializes fields that are common for all controllers such as current page details, navigation bar pages and user field.
     */
    public function __construct($page)
    {
        $this->_navPages = $this->model('NavBarPages')->getData();
        $currentPage = $this->model('CurrentPage', $page);
        $this->_pageDetails = $currentPage->getData();
        $this->_path = $currentPage->getPageUrl();
        $this->_user = $this->model('User');
    }

    /**
     * @method              model
     * @param               $model {model file name in models folder e.g for user 'User'}
     * @param               $parameter {parameter passed to model e.g. user id}
     * @desc                Creates a new model with an optional parameter.
     * @return              mixed|null
     */
    protected function model($model, $parameter = null)
    {
        if (file_exists('../app/models/' . $model . '.php')) {
            require_once '../app/models/' . $model . '.php';
            return new $model($parameter);
        }
        return null;
    }

    /**
     * @method              view
     * @param               $viewName {string}
     * @param               $view {path to index.php file in views folder e.g. for home page 'home/'}
     * @param               $data {data passed to the view as an array}
     * @desc                Creates a new view and assigns it to _view field.
     *                      It also sets the field in view that describes if user is logged in.
     */
    protected function view($viewName, $view, $data = [])
    {
        if (file_exists('../app/views/' . $view . '/index.php')) {
            $this->_view = new View($viewName, $view, $data);
            $this->_view->setUserIsLoggedIn($this->_user->isLoggedIn());
        }
    }

    /**
     *  Methods containing logic that is shared by more than one controller:
     */

    /**
     * @method              userSearch
     * @desc                Method handles functionality of user search bar in members and membership admin panel.
     *                      It gets data using UserSearch model and adds it to the view.
     */
    protected function userSearch()
    {
        if (Input::exists()) {
            if (Token::check(Input::getValue('token'))) {
                $userSearch = $this->model('UserSearch', trim(Input::getValue('search')))->getData();
                $this->_view->addViewData(['search' => $userSearch]);
            }
        }
    }

    /**
     * @method              updateUserDetails
     * @param               $user {object}
     * @param               $id {user id}
     * @desc                Method updates user details. Used in dashboard and admin panel.
     * @throws              Exception
     */
    protected function updateUserDetails($user, $id = null)
    {
        $user->updateUser([
            'u_first_name' => trim(Input::getValue('first_name')),
            'u_last_name' => trim(Input::getValue('last_name')),
            'u_address_1' => trim(Input::getValue('address_first_line')),
            'u_address_2' => trim(Input::getValue('address_second_line')),
            'u_postcode' => trim(Input::getValue('postcode')),
            'u_city' => trim(Input::getValue('city'))
        ], $id);
    }

    /**
     * @method              insertUserDetails
     * @param               $user {object}
     * @param               $groupId {groupId as int, 1 for standard user}
     * @desc                Method inserts user details to the database. Used in register user and admin panel.
     * @throws              Exception
     */
    protected function insertUserDetails($user, $groupId = 1)
    {
        $salt = Hash::generateSalt(32);
        $user->createUser([
            'u_first_name' => trim(Input::getValue('first_name')),
            'u_last_name' => trim(Input::getValue('last_name')),
            'u_address_1' => trim(Input::getValue('address_first_line')),
            'u_address_2' => trim(Input::getValue('address_second_line')),
            'u_postcode' => trim(Input::getValue('postcode')),
            'u_city' => trim(Input::getValue('city')),
            'u_username' => trim(Input::getValue('username')),
            'u_email' => trim(Input::getValue('email')),
            'u_password' => Hash::generateHash(Input::getValue('password'), $salt),
            'u_salt' => $salt,
            'u_group_id' => $groupId,
            'u_joined' => date('Y-m-d H-i-s')
        ]);
    }

    /**
     * @method              editComment
     * @param               $selectedComment {BlogComments object}
     * @param               $postCommentId {int}
     * @param               $redirect {string}
     * @desc                Edits post comment fields in the database. This does validation of data using validate object and does CSRF token check.
     *                      After updating the post comment, it redirects to $redirect location. Used in AdminBlog and AdminComments controllers.
     */
    protected function updateComment($selectedComment, $postCommentId, $redirect)
    {
        if (Input::exists()) {
            if (Token::check(Input::getValue('token'))) {

                // Validate using validate object
                $validate = new Validate();
                $validate->check($_POST, ValidationRules::getEditPostCommentRules());

                if ($validate->checkIfPassed()) {

                    try {

                        // Update comment
                        $selectedComment->updateComment($postCommentId, [
                            'pc_date' => trim(Input::getValue('date')),
                            'pc_time' => trim(Input::getValue('time')),
                            'pc_text' => trim(Input::getValue('comment_text')),
                            'pc_author' => trim(Input::getValue('comment_author'))
                        ]);

                        Session::flash('admin', 'You successfully edited post comment.');
                        Redirect::to($redirect);

                    } catch (Exception $e) {
                        $errorMessage = $e->getMessage();
                        $this->_view->setViewError($errorMessage);
                    }

                } else {
                    // Display a validation error
                    $errorMessage = $validate->getFirstErrorMessage();
                    $this->_view->setViewError($errorMessage);
                }

            }
        }
    }
}
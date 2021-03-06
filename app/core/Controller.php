<?php

/**
 *                          Class Controller
 * @desc                    Parent controller class. Includes fields that are shared between all controllers and methods to require models and to instantiate a view.
 *                          Additionally, includes methods that contain logic that is shared by more than one controller.
 */
abstract class Controller
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
     * @method              index
     * @desc                Default method in a controller. Renders index.php for given view.
     */
    abstract public function index();

    /**
     * @method              model
     * @param               $model {model file name in models folder e.g for user 'User'}
     * @param               $parameter {parameter passed to model e.g. user id}
     * @desc                Creates a new model with an optional parameter.
     * @return              mixed|null
     */
    protected function model($model, $parameter = null)
    {
        if (file_exists('./app/models/' . $model . '.php')) {
            require_once './app/models/' . $model . '.php';
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
        if (file_exists('./app/views/' . $view . '/index.php')) {
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
     * @desc                Method inserts user details to the database. Uses password salt from Hash class.
     *                      Used in register user and admin panel.
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
     * @method              getCaptcha
     * @param               $token {reCAPTCHA user response token from g-recaptcha-response}
     * @desc                Method used to get request from reCAPTCHA API. It uses secret API key and user token from g-recaptcha-response.
     *                      The is a json object with a score (1.0 is very likely a good interaction, 0.0 is very likely a bot).
     *                      Method returns true if response is success and score is greater > 0.5.
     * @return              bool
     */
    protected function getCaptcha($token)
    {
        $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $GLOBALS['config']['recaptcha']['private_key'] . '&response=' . $token);

        $decodedResponse = json_decode($response);

        if($decodedResponse->success === true && $decodedResponse->score > 0.5) {
            return true;
        } else {
            return false;
        }
    }
}
<?php

/**
 *                              Class AdminCoaches
 * @desc                        Controller for admin panel coaches area. Includes methods to add, edit and delete coaches working at the gym.
 */
class AdminCoaches extends Controller
{
    private $_page;
    private $_coaches;

    /**
     *                          AdminCoaches constructor.
     * @desc                    Constructor for admin coaches panel controller. Checks if user is logged in and has admin permission before instantiating view.
     *                          Instantiates coaches model and selects all coaches from the database.
     *                          Passes this data to the view along with user, navigation and this page data.
     *                          If user is not logged in or does not have admin permission it redirects to home page.
     */
    public function __construct()
    {
        $this->_page = 'admin';
        parent::__construct($this->_page);

        // View instantiated if user is logged in and has admin permissions
        if ($this->_user->isLoggedIn() && $this->_user->hasPermission('admin')) {

            $userData = $this->_user->getData();
            $this->_coaches = $this->model('Coaches')->selectCoaches();

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

    /**
     * @method                  index
     * @desc                    Default controller method. Renders admin panel - coach area. Displays coaches in a image gallery.
     */
    public function index()
    {
        $this->_view->setSubName(toLispCase(__CLASS__));
        $this->_view->renderView();
    }

    /**
     * @method                  add
     * @desc                    Method for adding a new coach form page in admin panel. Handles form submission.
     *                          Validates $_POST data using validate object. Also instantiates Image object, and checks if submitted image in $_FILES super global is valid.
     *                          Valid image: max size 500kB, formats: .jpg, .jpeg, .png and .gif.
     *                          If both validation checks are passed, it uploads the image to dist/img/coaches and adds coach data to the database.
     */
    public function add()
    {
        if (Input::exists()) {
            if (Token::check(Input::getValue('token'))) {

                // Validation using Validate object
                $validate = new Validate();
                $validate->check($_POST, ValidationRules::getCoachDetailsRules());

                // Create new Image
                $image = new Image('coach_image');

                if ($validate->checkIfPassed()) {
                    if ($image->checkIfValid(500, ['jpg', 'jpeg', 'png', 'gif'])) {

                        try {

                            // Uploads image and inserts image info into the database
                            $imageUrl = $this->_coaches->getImagePath() . '/coach-' . uniqid() . '.' . $image->getImageExtension();
                            $image->upload('dist/' . $imageUrl);

                            // Inserts class details
                            $this->_coaches->addCoach([
                                'co_first_name' => trim(Input::getValue('first_name')),
                                'co_last_name' => trim(Input::getValue('last_name')),
                                'co_email' => trim(Input::getValue('email')),
                                'co_focus' => trim(Input::getValue('focus')),
                                'co_img' => $imageUrl,
                                'co_facebook' => trim(Input::getValue('facebook_profile')),
                                'co_twitter' => trim(Input::getValue('twitter_profile')),
                                'co_linkedin' => trim(Input::getValue('linkedin_profile'))
                            ]);

                            Session::flash('admin', 'The coach has been added.');
                            Redirect::to('admin-coaches');

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
        $this->_view->setSubName(toLispCase(__CLASS__) . '/' . __FUNCTION__);
        $this->_view->renderView();
    }

    /**
     * @method                  edit
     * @param                   $coachId {string}
     * @desc                    Method for editing an existing coach form page in admin panel. Handles form submission.
     *                          Validates $_POST data using validate object. Also instantiates Image object, and checks if no image has been submitted or if submitted image in $_FILES is valid.
     *                          Valid image: max size: 500kB, formats: .jpg, .jpeg, .png and .gif.
     *                          If validation passes, it updates coach details in the database.
     *                          If valid image has been submitted, it replaces the current image with the new one and updates the image url in the database.
     */
    public function edit($coachId = '')
    {
        $selectedCoach = $this->_coaches->getCoach($coachId);

        if (isset($selectedCoach) && is_numeric($coachId)) {
            if (Input::exists()) {
                if (Token::check(Input::getValue('token'))) {

                    // Validation using Validate object
                    $validate = new Validate();
                    $validate->check($_POST, ValidationRules::getCoachDetailsRules());

                    // Create new Image
                    $image = new Image('coach_image');

                    if ($validate->checkIfPassed()) {
                        if (!$image->exists() || $image->checkIfValid(500, ['jpg', 'jpeg', 'png', 'gif'])) {

                            try {

                                // Update coach details
                                $this->_coaches->updateCoach($coachId, [
                                    'co_first_name' => trim(Input::getValue('first_name')),
                                    'co_last_name' => trim(Input::getValue('last_name')),
                                    'co_email' => trim(Input::getValue('email')),
                                    'co_focus' => trim(Input::getValue('focus')),
                                    'co_facebook' => trim(Input::getValue('facebook_profile')),
                                    'co_twitter' => trim(Input::getValue('twitter_profile')),
                                    'co_linkedin' => trim(Input::getValue('linkedin_profile'))
                                ]);

                                if ($image->exists()) {

                                    // Replaces image and updates image info in the database
                                    $newImageUrl = $this->_coaches->getImagePath() . "/coach-{$coachId}." . $image->getImageExtension();
                                    $image->replace('dist/' . $selectedCoach['co_img'], 'dist/' . $newImageUrl);
                                    $this->_coaches->updateCoach($coachId, [
                                        'co_img' => $newImageUrl
                                    ]);
                                }

                                Session::flash('admin', 'Coach details have been updated.');
                                Redirect::to('admin-coaches');

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

    /**
     * @method                  delete
     * @param                   $coachId {string}
     * @desc                    Method for deleting coach confirmation page. It handles form submission if user decides to delete selected coach.
     *                          It instantiates Image object and Scheduled Classes model. It deletes selected coach from scheduled classes and deletes coach data from the database.
     *                          It also deletes coach image using Image object.
     */
    public function delete($coachId = '')
    {
        if (Input::exists()) {
            if (Token::check(Input::getValue('token'))) {

                $selectedCoach = $this->_coaches->getCoach($coachId);
                if (isset($selectedCoach) && is_numeric($coachId)) {

                    // Instantiating new Image object
                    $image = new Image();

                    try {
                        // Delete coaches from scheduled classes
                        $this->model('ScheduledClasses')->deleteCoach($coachId);
                        // Delete coach
                        $this->_coaches->deleteCoach($coachId);
                        // Delete coach image
                        $image->delete('dist/' . $selectedCoach['co_img']);

                        Session::flash('admin', 'Selected coach has been deleted.');
                        Redirect::to('admin-coaches');

                    } catch (Exception $e) {
                        $errorMessage = $e->getMessage();
                        $this->_view->setViewError($errorMessage);
                    }
                }
            }
        }
        $this->_view->addViewData(['itemToBeDeleted' => 'coach']);
        $this->_view->setSubName(toLispCase(__CLASS__) . '/' . __FUNCTION__);
        $this->_view->renderView();
    }
}
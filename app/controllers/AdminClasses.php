<?php

/**
 *                              Class AdminClasses
 * @desc                        Controller for admin panel classes area. Includes method to add, edit and delete class types that are run by the gym.
 */
class AdminClasses extends Controller
{
    private $_page;
    private $_classes;

    /**
     *                          AdminClasses constructor.
     * @desc                    Constructor for admin classes panel controller. Checks if user is logged in and has admin permission before instantiating view.
     *                          Instantiates classes model and selects all classes from the database.
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
            $this->_classes = $this->model('Classes')->selectClasses();

            $this->view($this->_page, $this->_path, [
                'navPages' => $this->_navPages,
                'pageDetails' => $this->_pageDetails,
                'user' => $userData,
                'classes' => $this->_classes->getData()
            ]);
        } else {
            Redirect::to('home');
        }
    }

    /**
     * @method                  index
     * @desc                    Default controller method. Renders admin panel - classes area. Displays classes in a image gallery.
     */
    public function index()
    {
        $this->_view->setSubName(toLispCase(__CLASS__));
        $this->_view->renderView();
    }

    /**
     * @method                  add
     * @desc                    Method for adding a new class form page in admin panel. Handles form submission.
     *                          Validates $_POST data using validate object. Also instantiates Image object, and checks if submitted image in $_FILES super global is valid.
     *                          Valid image: max size 500kB, formats: .jpg, .jpeg, .png and .gif.
     *                          If both validation checks are passed, it uploads the image to dist/img/classes and adds image details to the database.
     *                          It uses the class image id and updates class details.
     */
    public function add()
    {
        if (Input::exists()) {
            if (Token::check(Input::getValue('token'))) {

                // Validation using Validate object
                $validate = new Validate();
                $validate->check($_POST, ValidationRules::getClassDetailsRules());

                // Create new Image
                $image = new Image('class_image');

                if ($validate->checkIfPassed()) {
                    if ($image->checkIfValid(500, ['jpg', 'jpeg', 'png', 'gif'])) {

                        try {

                            // Uploads image and inserts image info into the database
                            $imageUrl = $this->_classes->getImagePath() . '/class-' . uniqid() . '.' . $image->getImageExtension();
                            $image->upload(DIST_RELATIVE_PATH . $imageUrl);

                            $this->_classes->addClassImageDetails([
                                'cl_img_alt' => trim(Input::getValue('class_image_text')),
                                'cl_img_url' => $imageUrl
                            ]);

                            // Finds class image id based on url
                            $classImgId = $this->_classes->findClassImageId($imageUrl);

                            // Inserts class details
                            $this->_classes->addClass([
                                'cl_name' => trim(Input::getValue('class_name')),
                                'cl_desc' => trim(Input::getValue('description')),
                                'cl_duration' => trim(Input::getValue('duration')),
                                'cl_max_people' => trim(Input::getValue('max_no_people')),
                                'cl_img_id' => $classImgId
                            ]);

                            Session::flash('admin', 'The class has been added.');
                            Redirect::to('admin-classes');

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
     * @param                   $classId {string}
     * @desc                    Method for editing an existing class form page in admin panel. Handles form submission.
     *                          Validates $_POST data using validate object. Also instantiates Image object, and checks if no image has been submitted or if submitted image in $_FILES is valid.
     *                          Valid image: max size: 500kB, formats: .jpg, .jpeg, .png and .gif.
     *                          If validation passes, it updates class details in the database.
     *                          If valid image has been submitted, it replaces the current image with the new one and updates the image url in the database.
     */
    public function edit($classId = '')
    {
        $selectedClass = $this->_classes->getClass($classId);
        if (isset($selectedClass) && is_numeric($classId)) {

            if (Input::exists()) {
                if (Token::check(Input::getValue('token'))) {

                    // Validation using Validate object
                    $validate = new Validate();
                    $validate->check($_POST, ValidationRules::getClassDetailsRules());

                    // Create new Image
                    $image = new Image('class_image');

                    if ($validate->checkIfPassed()) {
                        if (!$image->exists() || $image->checkIfValid(500, ['jpg', 'jpeg', 'png', 'giff'])) {

                            try {
                                // Update class details
                                $this->_classes->updateClass($classId, [
                                    'cl_name' => trim(Input::getValue('class_name')),
                                    'cl_desc' => trim(Input::getValue('description')),
                                    'cl_duration' => trim(Input::getValue('duration')),
                                    'cl_max_people' => trim(Input::getValue('max_no_people'))
                                ]);

                                if ($image->exists()) {

                                    // Replaces image and updates image info in the database
                                    $newImageUrl = $this->_classes->getImagePath() . "/class-{$classId}." . $image->getImageExtension();
                                    $image->replace(DIST_RELATIVE_PATH . $selectedClass['cl_img_url'], DIST_RELATIVE_PATH . $newImageUrl);

                                    $this->_classes->updateClassImageDetails($classId, [
                                        'cl_img_alt' => trim(Input::getValue('class_image_text')),
                                        'cl_img_url' => $newImageUrl
                                    ]);

                                } else {

                                    // Updates alt text for existing image
                                    $this->_classes->updateClassImageDetails($classId, [
                                        'cl_img_alt' => trim(Input::getValue('class_image_text'))
                                    ]);

                                }

                                Session::flash('admin', 'Class details have been updated.');
                                Redirect::to('admin-classes');

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
            $this->_view->addViewData(['selectedClass' => $selectedClass]);
        } else {
            Redirect::to('admin-classes');
        }
        $this->_view->setSubName(toLispCase(__CLASS__) . '/' . __FUNCTION__);
        $this->_view->renderView();
    }

    /**
     * @method                  delete
     * @param                   $classId {string}
     * @desc                    Method for deleting class confirmation page. It handles form submission if user decides to delete selected class.
     *                          It instantiates Image object and Scheduled Classes model. It deletes selected class type from scheduled classes and deletes class data from the database.
     *                          It also deletes class image using Image object and class image details.
     */
    public function delete($classId = '')
    {
        if (Input::exists()) {
            if (Token::check(Input::getValue('token'))) {

                $selectedClass = $this->_classes->getClass($classId);
                if (isset($selectedClass) && is_numeric($classId)) {

                    // Instantiating new image object
                    $image = new Image();

                    try {
                        // Delete scheduled classes
                        $this->model('ScheduledClasses')->deleteClassesByClassId($classId);
                        // Delete class
                        $this->_classes->deleteClass($classId);
                        // Delete class image details
                        $this->_classes->deleteClassImageDetails($classId);
                        // Delete class image
                        $image->delete(DIST_RELATIVE_PATH . $selectedClass['cl_img_url']);

                        Session::flash('admin', 'Selected class has been deleted.');
                        Redirect::to('admin-classes');

                    } catch (Exception $e) {
                        $errorMessage = $e->getMessage();
                        $this->_view->setViewError($errorMessage);
                    }
                }
            }
        }
        $this->_view->addViewData(['itemToBeDeleted' => 'class']);
        $this->_view->setSubName(toLispCase(__CLASS__) . '/' . __FUNCTION__);
        $this->_view->renderView();
    }
}
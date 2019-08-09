<?php

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
     * @desc
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
                            $image->upload('dist/' . $imageUrl);

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
                                    $newImageUrl = $this->_classes->getImagePath($classId) . "/class-{$classId}." . $image->getImageExtension();
                                    $image->replace('dist/' . $selectedClass['cl_img_url'], 'dist/' . $newImageUrl);

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
                        $image->delete('dist/' . $selectedClass['cl_img_url']);

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
<?php

class AdminClasses extends Controller
{
    private $_page;
    private $_classes;

    public function __construct()
    {
        $this->_page = 'admin';
        parent::__construct($this->_page);

        // View instantiated if user is logged in and has admin permissions
        if ($this->_user->isLoggedIn() && $this->_user->hasPermission('admin')) {

            $userData = $this->_user->getData();
            $this->_classes = $this->model('Classes');
            $this->_classes->selectClasses();

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

    public function index()
    {
        $this->_view->setSubName(toLispCase(__CLASS__));
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
                    $validate->check($_POST, ValidationRules::getValidClassRules());

                    // Create new File
                    $image = new File('class_image');

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
                                    $newImageUrl = $this->_classes->getImageLocation($classId) . '/' . $image->getName();
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

                    // Instantiating new file object
                    $file = new File();

                    try {
                        // Delete scheduled classes
                        $this->model('ScheduledClasses')->deleteClassesByClassId($classId);
                        // Delete class
                        $this->_classes->deleteClass($classId);
                        // Delete class image details
                        $this->_classes->deleteClassImageDetails($classId);
                        // Delete class image
                        $file->delete('dist/' . $selectedClass['cl_img_url']);

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

    public function add()
    {
        if (Input::exists()) {
            if (Token::check(Input::getValue('token'))) {

                // Validation using Validate object
                $validate = new Validate();
                $validate->check($_POST, ValidationRules::getValidClassRules());

                // Create new File
                $image = new File('class_image');

                if ($validate->checkIfPassed()) {
                    if ($image->checkIfValid(500, ['jpg', 'jpeg', 'png', 'giff'])) {

                        try {

                            // Uploads image and inserts image info into the database
                            $imageUrl = $this->_classes->getImageLocation() . '/' . $image->getName();
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
}
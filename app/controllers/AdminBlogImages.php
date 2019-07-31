<?php

class AdminBlogImages extends Controller
{
    private $_page;
    private $_blogImages;

    public function __construct()
    {
        $this->_page = 'admin';
        parent::__construct($this->_page);

        if ($this->_user->isLoggedIn() && $this->_user->hasPermission('admin')) {

            $userData = $this->_user->getData();

            $this->_blogImages = $this->model('BlogPostImages');

            $this->view($this->_page, $this->_path, [
                'navPages' => $this->_navPages,
                'pageDetails' => $this->_pageDetails,
                'user' => $userData,
            ]);
        } else {
            Redirect::to('home');
        }
    }

    public function index()
    {
        $this->_blogImages->selectImages();
        $this->_view->addViewData([
            'images' => $this->_blogImages->getData(),
            'defaultImage' => $this->_blogImages->getDefaultImageData()
        ]);
        $this->_view->setSubName(toLispCase(__CLASS__));
        $this->_view->renderView();
    }

    public function add()
    {
        if (Input::exists()) {
            if (Token::check(Input::getValue('token'))) {

                // Validation using Validate object
                $validate = new Validate();
                $validate->check($_POST, ValidationRules::getBlogImageRules());

                // Create new Image
                $image = new Image('post_image');

                if ($validate->checkIfPassed()) {
                    if ($image->checkIfValid(500, ['jpg', 'jpeg', 'png', 'gif'])) {

                        try {

                            // Unique id for image name
                            $uniqueId = uniqid();

                            // Uploads image thumbnail
                            $thumbnailUrl = $this->_blogImages->getThumbnailPath() . '/thumb-post-img-' . $uniqueId . '.' . $image->getImageExtension();
                            $image->createThumbnail(100, 56, 'dist/' . $thumbnailUrl);

                            // Uploads image
                            $imageUrl = $this->_blogImages->getImagePath() . '/post-img-' . $uniqueId . '.' . $image->getImageExtension();
                            $image->upload('dist/' . $imageUrl);

                            // Inserts image details to the database
                            $this->_blogImages->addImageDetails([
                                'p_img_url' => $imageUrl,
                                'p_thumb_url' => $thumbnailUrl,
                                'p_img_alt' => trim(Input::getValue('post_image_text')),
                                'p_img_default' => 0
                            ]);

                            Session::flash('admin', 'The blog post image has been added to the gallery.');
                            Redirect::to('admin-blog-images');

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

    public function delete($blogImageId = '')
    {
        if (Input::exists()) {
            if (Token::check(Input::getValue('token'))) {

                $selectedImage = $this->_blogImages->selectImage($blogImageId)->getData();

                if (isset($selectedImage) && !$this->_blogImages->checkIfDefaultImage()) {

                    // Instantiating new image object
                    $image = new Image();

                    try {

                        // Delete thumbnail
                        $image->delete('dist/' . $selectedImage['p_thumb_url']);
                        // Delete image
                        $image->delete('dist/' . $selectedImage['p_img_url']);
                        // Delete image details from the database
                        $this->_blogImages->deleteImageDetails($blogImageId);

                        Session::flash('admin', 'Selected image has been deleted from the gallery.');
                        Redirect::to('admin-blog-images');


                    } catch (Exception $e) {
                        $errorMessage = $e->getMessage();
                        $this->_view->setViewError($errorMessage);
                    }

                }
            }
        }
        $this->_view->addViewData(['itemToBeDeleted' => 'image']);
        $this->_view->setSubName(toLispCase(__CLASS__) . '/' . __FUNCTION__);
        $this->_view->renderView();
    }
}
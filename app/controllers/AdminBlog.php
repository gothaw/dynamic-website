<?php

class AdminBlog extends Controller
{
    private $_page;
    private $_posts;

    public function __construct()
    {
        $this->_page = 'admin';
        parent::__construct($this->_page);

        // View instantiated if user is logged in and has admin permissions
        if ($this->_user->isLoggedIn() && $this->_user->hasPermission('admin')) {

            $userData = $this->_user->getData();

            $this->_posts = $this->model('BlogPosts');

            $this->view($this->_page, $this->_path, [
                'navPages' => $this->_navPages,
                'pageDetails' => $this->_pageDetails,
                'user' => $userData,
            ]);
        } else {
            Redirect::to('home');
        }
    }

    public function index($pageNumber = '1')
    {
        $this->_posts->selectPosts(10, $pageNumber, null, false);
        $this->_view->addViewData([
            'posts' => $this->_posts->getData(),
            'page' => $this->_posts->getCurrentPageNumber(),
            'lastPage' => $this->_posts->getNumberOfPages()
        ]);
        $this->_view->setSubName(toLispCase(__CLASS__));
        $this->_view->renderView();
    }

    public function edit($postId = '')
    {
        $selectedPost = $this->_posts->selectPost($postId, false)->getData();

        if (isset($selectedPost) && is_numeric($postId)) {

            $postImages = $this->model('BlogPostImages')->selectImages();

            $this->_view->addViewData([
                'post' => $selectedPost,
                'images' => $postImages->getData()
            ]);
            $this->_view->setSubName(toLispCase(__CLASS__) . '/' . __FUNCTION__);
            $this->_view->renderView();
        } else {
            Redirect::to('admin-blog');
        }
    }

    public function changeSelectedImage()
    {
        if (Input::exists() && is_numeric(Input::getValue('p_img_id'))) {
            $selectedImage = $this->model('BlogPostImages')->selectImage(Input::getValue('p_img_id'))->getData();
            if (isset($selectedImage)) {
                $returnArray = ['imgUrl' => DIST . $selectedImage['p_img_url'], 'imgAlt' => $selectedImage['p_img_alt']];
                echo json_encode($returnArray);
            }
        } else {
            Redirect::to('admin-blog');
        }
    }

}
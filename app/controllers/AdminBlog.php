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

            if (Input::exists()) {
                if (Token::check(Input::getValue('token'))) {

                    // Validate using validate object
                    $validate = new Validate();
                    $validate->check($_POST, ValidationRules::getPostRules());

                    if ($validate->checkIfPassed()) {

                        try {

                            // Update blog post
                            $this->_posts->updatePost($postId, [
                                'p_title' => trim(Input::getValue('post_title')),
                                'p_text' => trim(Input::getValue('post_text')),
                                'p_category' => trim(strtolower(Input::getValue('post_category'))),
                                'p_date' => trim(Input::getValue('date')),
                                'p_time' => trim(Input::getValue('time')),
                                'p_author' => trim(strtolower(Input::getValue('post_author'))),
                                'p_img_id' => Input::getValue('post_image')
                            ]);

                            // Update blog post tags
                            $blogPostTags = $this->model('BlogPostTags');
                            $blogPostTags->updateTags($postId, trim(Input::getValue('post_tags')));

                            Session::flash('admin', 'You successfully edited the blog post.');
                            Redirect::to('admin-blog');

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

    public function delete($postId = '')
    {
        if (Input::exists()) {
            if (Token::check(Input::getValue('token'))) {

                $selectedPost = $this->_posts->selectPost($postId, false)->getData();

                if (isset($selectedPost) && is_numeric($postId)) {

                    try {
                        // Delete Post tags
                        $blogPostTags = $this->model('BlogPostTags');
                        $blogPostTags->deleteTags($postId);

                        // Delete Post comments
                        $blogComments = $this->model('BlogComments');
                        $blogComments->deleteCommentsByPostId($postId);

                        // Delete Post
                        $this->_posts->deletePost($postId);

                        Session::flash('admin', 'Blog post has been deleted.');
                        Redirect::to('admin-blog');

                    } catch (Exception $e) {
                        $errorMessage = $e->getMessage();
                        $this->_view->setViewError($errorMessage);
                    }
                }
            }
        }
        $this->_view->addViewData(['itemToBeDeleted' => 'blog post']);
        $this->_view->setSubName(toLispCase(__CLASS__) . '/' . __FUNCTION__);
        $this->_view->renderView();
    }

    public function add()
    {
        if (Input::exists()) {
            if (Token::check(Input::getValue('token'))) {

                // Validate using validate object
                $validate = new Validate();
                $validate->check($_POST, ValidationRules::getPostRules());

                if ($validate->checkIfPassed()) {

                    try {

                        // Add blog post
                        $this->_posts->addPost([
                            'p_title' => trim(Input::getValue('post_title')),
                            'p_text' => trim(Input::getValue('post_text')),
                            'p_category' => trim(strtolower(Input::getValue('post_category'))),
                            'p_date' => trim(Input::getValue('date')),
                            'p_time' => trim(Input::getValue('time')),
                            'p_author' => trim(strtolower(Input::getValue('post_author'))),
                            'p_comments' => 0,
                            'p_img_id' => Input::getValue('post_image')
                        ]);

                        // Add blog post tags
                        $blogPostId = $this->_posts->findMostRecentPostById();
                        $blogPostTags = $this->model('BlogPostTags');
                        $blogPostTags->insertTags($blogPostId, trim(Input::getValue('post_tags')));

                        Session::flash('admin', 'You successfully added a blog post.');
                        Redirect::to('admin-blog');

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

        $postImages = $this->model('BlogPostImages')->selectImages();
        $this->_view->addViewData([
            'images' => $postImages->getData()
        ]);

        $this->_view->setSubName(toLispCase(__CLASS__) . '/' . __FUNCTION__);
        $this->_view->renderView();
    }

    public function comments($postId = '')
    {
        $selectedPost = $this->_posts->selectPost($postId, false)->getData();

        if (isset($selectedPost) && is_numeric($postId)) {

            $comments = $this->model("BlogComments")->selectPostComments($postId);

            $this->_view->addViewData([
                'comments' => $comments->getData(),
                'selectedPost' => $selectedPost
            ]);

            $this->_view->setSubName(toLispCase(__CLASS__) . '/' . __FUNCTION__);
            $this->_view->renderView();

        } else {
            Redirect::to('admin-blog');
        }
    }

    public function commentsEdit($postId = '' , $postCommentId = '')
    {
        $selectedPost = $this->_posts->selectPost($postId)->getData();
        $selectedComment = $this->model("BlogComments")->selectComment($postCommentId);

        if (isset($selectedPost) && isset($selectedComment)) {

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
                            Redirect::to('admin-blog/comments/' . $postId);

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

            $this->_view->addViewData([
                'selectedPost' => $selectedPost,
                'selectedComment' => $selectedComment->getData()
            ]);

            $this->_view->setSubName(toLispCase(__CLASS__) . '/' . toLispCase(__FUNCTION__));
            $this->_view->renderView();

        } else {
            Redirect::to('admin-blog');
        }
    }

    public function commentsDelete($postId = '', $postCommentId = '')
    {
        if (Input::exists()) {
            if (Token::check(Input::getValue('token'))) {

                $selectedPost = $this->_posts->selectPost($postId);
                $selectedComment = $this->model("BlogComments")->selectComment($postCommentId);

                if (isset($selectedPost) && isset($selectedComment)) {

                    try {

                        // Delete comment
                        $selectedComment->deleteComment($postCommentId);

                        // Decrease total number of comments under the post by 1
                        $selectedPost->removeOneCommentFromPost();

                        Session::flash('admin', 'You successfully deleted post comment.');
                        Redirect::to('admin-blog/comments/' . $postId);

                    } catch (Exception $e) {
                        $errorMessage = $e->getMessage();
                        $this->_view->setViewError($errorMessage);
                    }
                }
            }
        }
        $this->_view->addViewData(['itemToBeDeleted' => 'comment']);
        $this->_view->setSubName(toLispCase(__CLASS__) . '/' . toLispCase(__FUNCTION__));
        $this->_view->renderView();
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
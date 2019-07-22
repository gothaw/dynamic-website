<?php

class Blog extends Controller
{
    private $_page;
    private $_posts;
    private $_sideBar;

    public function __construct()
    {
        $this->_page = 'blog';

        parent::__construct($this->_page);

        $this->_posts = $this->model('BlogPosts');
        $this->_sideBar = $this->model('BlogSideBar');

        $this->view($this->_page, $this->_path, [
            'navPages' => $this->_navPages,
            'pageDetails' => $this->_pageDetails,
            'categories' => $this->_sideBar->getCategories(),
            'tags' => $this->_sideBar->getTags(),
            'popularPosts' => $this->_sideBar->getPopularPosts()
        ]);
    }

    public function index($page = '1')
    {
        $this->_posts->selectPosts(4, $page);
        $this->_view->addViewData([
            'posts' => $this->_posts->getData(),
            'page' => $this->_posts->getCurrentPageNumber(),
            'lastPage' => $this->_posts->getNumberOfPages()
        ]);
        $this->_view->setSubName(toLispCase(__CLASS__));
        $this->_view->renderView();
    }

    public function tag($tag = '', $page = '1')
    {
        $tag = str_replace('_', ' ', $tag);

        // Validation using Validate object
        $validate = new Validate();
        $validate->check(['tag' => $tag], ValidationRules::getPostTagRules());

        if ($validate->checkIfPassed()) {

            $this->_posts->selectPostsByTag(4, $page, $tag);

            $this->_view->addViewData([
                'posts' => $this->_posts->getData(),
                'page' => $this->_posts->getCurrentPageNumber(),
                'lastPage' => $this->_posts->getNumberOfPages()
            ]);
            $this->_view->setSubName(toLispCase(__CLASS__) . '/' . __FUNCTION__ . '/' . escape($tag));
            $this->_view->renderView();

        } else {
            Redirect::to('blog');
        }
    }

    public function category($category = '', $page = '1')
    {
        $category = str_replace('_', ' ', $category);

        // Validation using Validate object
        $validate = new Validate();
        $validate->check(['category' => $category], ValidationRules::getPostCategoryRules());

        if ($validate->checkIfPassed()) {

            $this->_posts->selectPosts(4, $page, $category);

            $this->_view->addViewData([
                'posts' => $this->_posts->getData(),
                'page' => $this->_posts->getCurrentPageNumber(),
                'lastPage' => $this->_posts->getNumberOfPages()
            ]);
            $this->_view->setSubName(toLispCase(__CLASS__) . '/' . __FUNCTION__ . '/' . escape($category));
            $this->_view->renderView();

        } else {
            Redirect::to('blog');
        }
    }

    public function post($postId = '')
    {
        $selectedPost = $this->_posts->selectPost($postId);

        if (isset($selectedPost) && is_numeric($postId)) {

            $postComments = $this->model('BlogComments')->selectPostComments($postId);

            $this->addComment($selectedPost);

            $this->_view->addViewData([
                'post' => $selectedPost->getData(),
                'postComments' => $postComments->getData()
            ]);
            $this->_view->setSubName(toLispCase(__CLASS__) . '/' . __FUNCTION__);
            $this->_view->renderView();

        } else {
            Redirect::to('blog');
        }
    }

    /**
     * @param $selectedPost {object} BlogPosts object with single post selected in _data field.
     */
    private function addComment($selectedPost)
    {
        if (Input::exists() && $this->_user->isLoggedIn()) {

            if (Token::check(Input::getValue('token'))) {

                // Validation using Validate object
                $validate = new Validate();
                $validate->check($_POST, ValidationRules::getAddPostCommentRules());

                if ($validate->checkIfPassed()) {

                    try {

                        $comment = $this->model('BlogComments');
                        $userData = $this->_user->getData();
                        $postId = $selectedPost->getPostIdFromData();

                        // Add comment
                        $comment->addComment([
                            'p_id' => $postId,
                            'pc_date' => date('Y-m-d'),
                            'pc_time' => date('H:i'),
                            'pc_text' => trim(Input::getValue('comment_text')),
                            'pc_author' => $userData['u_first_name'] . ' ' . $userData['u_last_name'],
                            'pc_approved' => 0
                        ]);

                        Session::flash('blog', 'Thank you for commenting. Your comment will be added when it is accepted by our moderators.');
                        Redirect::to('blog/post/' . $postId);

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
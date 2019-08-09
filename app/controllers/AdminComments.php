<?php

class AdminComments extends Controller
{
    private $_page;
    private $_comments;

    /**
     *                          AdminComments constructor.
     * @desc                    Constructor for admin comments panel controller. Checks if user is logged in and has admin permission before instantiating view.
     *                          Instantiates view with user, navigation bar and this page data.
     *                          If user is not logged in or does not have admin permission it redirects to home page.
     */
    public function __construct()
    {
        $this->_page = 'admin';
        parent::__construct($this->_page);

        if ($this->_user->isLoggedIn() && $this->_user->hasPermission('admin')) {

            $userData = $this->_user->getData();

            $this->_comments = $this->model('BlogComments');

            $this->view($this->_page, $this->_path, [
                'navPages' => $this->_navPages,
                'pageDetails' => $this->_pageDetails,
                'user' => $userData,
            ]);
        } else {
            Redirect::to('home');
        }
    }

    /**
     * @method                  index
     * @param                   $pageNumber {string}
     * @desc                    Default controller method. Renders admin panel - comment moderation area. Displays unapproved comments in a table with 10 comments per page.
     *                          Invokes selectCommentsForApproval method for given page number passed as parameter in URL.
     *                          Adds selected comments data to the view along with current page number and last page number.
     *
     */
    public function index($pageNumber = '1')
    {
        $this->_comments->selectCommentsForApproval(10, $pageNumber);
        $this->_view->addViewData([
            'comments' => $this->_comments->getData(),
            'page' => $this->_comments->getCurrentPageNumber(),
            'lastPage' => $this->_comments->getNumberOfPages()
        ]);
        $this->_view->setSubName(toLispCase(__CLASS__));
        $this->_view->renderView();
    }

    /**
     * @method                  approve
     * @param                   $postId {string}
     * @param                   $postCommentId {string}
     * @desc                    Method for approve comment form page in admin panel. Adds selected comment data to the view.
     *                          Handles edit blog post form submission. Validates the $_POST data using validate object.
     *                          If validation passes, it updates comment data and changes status of comment to approved (`pc_approved`).
     *                          It also increases number of comments under selected post by one.
     */
    public function approve($postId = '', $postCommentId = '')
    {
        $selectedPost = $this->model('BlogPosts')->selectPost($postId);
        $selectedComment = $this->model("BlogComments")->selectComment($postCommentId);

        if (isset($selectedComment) && isset($selectedPost)) {

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
                                'pc_author' => trim(Input::getValue('comment_author')),
                                'pc_approved' => 1
                            ]);

                            // Increase number of comments under selected post by one
                            $selectedPost->addOneCommentToPost();

                            Session::flash('admin', 'You have approved and moderated this comment.');
                            Redirect::to('admin-comments');

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
                'selectedComment' => $selectedComment->getData()
            ]);

            $this->_view->setSubName(toLispCase(__CLASS__) . '/' . __FUNCTION__);
            $this->_view->renderView();

        } else {
            Redirect::to('admin-comments');
        }
    }

    /**
     * @method                  delete
     * @param                   $postCommentId {string}
     * @desc                    Method for deleting unapproved comment confirmation page. It handles form submission if user decides to delete the comment.
     */
    public function delete($postCommentId = '')
    {
        if (Input::exists()) {
            if (Token::check(Input::getValue('token'))) {

                $selectedComment = $this->model("BlogComments")->selectComment($postCommentId);

                if (isset($selectedComment)) {

                    try {
                        // Delete comment
                        $selectedComment->deleteComment($postCommentId);

                        Session::flash('admin', 'You successfully deleted post comment.');
                        Redirect::to('admin-comments');

                    } catch (Exception $e) {
                        $errorMessage = $e->getMessage();
                        $this->_view->setViewError($errorMessage);
                    }
                }
            }
        }

        $this->_view->addViewData(['itemToBeDeleted' => 'comment']);
        $this->_view->setSubName(toLispCase(__CLASS__) . '/' . __FUNCTION__);
        $this->_view->renderView();
    }
}
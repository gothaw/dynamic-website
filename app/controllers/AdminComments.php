<?php

class AdminComments extends Controller
{
    private $_page;
    private $_comments;

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

    public function index($pageNumber = '1')
    {
        $this->_comments->selectCommentsForApproval(5,$pageNumber);
        $this->_view->addViewData([
            'comments' => $this->_comments->getData(),
            'page' => $this->_comments->getCurrentPageNumber(),
            'lastPage' => $this->_comments->getNumberOfPages()
        ]);
        $this->_view->setSubName(toLispCase(__CLASS__));
        $this->_view->renderView();
    }

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
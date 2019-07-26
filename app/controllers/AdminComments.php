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

    public function edit($postCommentId = '')
    {
        $selectedComment = $this->model("BlogComments")->selectComment($postCommentId);

        if (isset($selectedComment)) {

            // Updates comment using method in parent class
            $this->updateComment($selectedComment, $postCommentId, 'admin-comments');

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

    public function approveComment()
    {

    }
}
<?php

class Contact extends Controller
{
    private $_page;

    public function __construct()
    {
        $this->_page = 'contact';

        parent::__construct($this->_page);

        $this->view($this->_page, $this->_path, [
            'navPages' => $this->_navPages,
            'pageDetails' => $this->_pageDetails
        ]);
    }

    public function index()
    {
        $this->_view->renderView();
    }

    public function send()
    {
        if (Input::exists()) {
            if (Token::check(Input::getValue('token'))) {

                // Validation using Validate object
                $validate = new Validate();
                $validate->check($_POST, ValidationRules::getContactFormMessageRules());

                if ($validate->checkIfPassed()) {

                    $name = escape(Input::getValue('name'));
                    $subject = escape(Input::getValue('subject'));
                    $mailFrom = escape(Input::getValue('email'));
                    $message = escape(Input::getValue('message'));

                    $emailMessage = new Email($name, $subject, $mailFrom, $message);

                    if ($emailMessage->send()) {

                        Session::flash('contact', 'Email sent. We will contact you shortly. Thanks!');
                        Redirect::to('contact');

                    } else {
                        $errorMessage = 'Something went wrong sorry.';
                        $this->_view->setViewError($errorMessage);
                    }

                } else {

                    // Display an Error
                    $errorMessage = $validate->getFirstErrorMessage();
                    $this->_view->setViewError($errorMessage);
                }
            }
        }
        $this->_view->renderView();
    }
}
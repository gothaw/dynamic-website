<?php

class Contact extends Controller
{
    private $_page;

    /**
     *                          Contact constructor.
     * @desc                    Constructor for contact page. Instantiates view navigation bar and this page data.
     */
    public function __construct()
    {
        $this->_page = 'contact';

        parent::__construct($this->_page);

        $this->view($this->_page, $this->_path, [
            'navPages' => $this->_navPages,
            'pageDetails' => $this->_pageDetails
        ]);
    }

    /**
     * @method                  index
     * @desc                    Default controller method. Renders contact page view.
     */
    public function index()
    {
        $this->_view->renderView();
    }

    /**
     * @method                  send
     * @desc                    Method handles submission of contact form. Validates form data using validate object.
     *                          If validation passes it sends email using Email class.
     */
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
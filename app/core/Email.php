<?php

class Email
{
    private $_name;
    private $_subject;
    private $_mailFrom;
    private $_body;
    private $_header;

    /**
     *                              Email constructor.
     * @param                       $name {email name}
     * @param                       $subject {email subject}
     * @param                       $mailFrom {email from}
     * @param                       $message {email message}
     * @desc                        Email constructor, also initializes email body for given $message.
     */
    public function __construct($name, $subject, $mailFrom, $message)
    {
        $this->_name = $name;
        $this->_subject = $subject;
        $this->_mailFrom = $mailFrom;
        $this->_header = "From: " . $mailFrom;
        $this->_body = "You have recieved an email from " . $name . ".\n\n" . $message;
    }

    /**
     * @method                      send
     * @desc                        Method sends an email to EMAIL_TO constant defined in config.php using mail function.
     * @return                      bool
     */
    public function send()
    {
        if(mail(EMAIL_TO, $this->_subject, $this->_body, $this->_header)){
            return true;
        }
        else{
            return false;
        }
    }
}
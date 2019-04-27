<?php

class Home extends Controller
{
    private $_page;
    private $_classes = null;
    private $_opinions = null;

    public function __construct()
    {
        $this->_page = 'home';
        $this->_classes = $this->model('Classes', 4)->getClassesDetails();
        $this->_opinions = $this->model('ClientOpinions', 6)->getClientOpinions();

        parent::__construct($this->_page);

        $this->view($this->_page, $this->_path, [
            'navPages' => $this->_navPages,
            'pageDetails' => $this->_pageDetails,
            'classes' => $this->_classes,
            'opinions' => $this->_opinions
        ]);
    }

    public function index()
    {
        // home banner used instead of standard banner
        $includeStandardBanner = false;

        $this->_view->renderView($includeStandardBanner);
    }
}
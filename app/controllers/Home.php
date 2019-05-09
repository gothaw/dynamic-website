<?php

class Home extends Controller
{
    private $_page;
    private $_classes = null;
    private $_opinions = null;

    public function __construct()
    {
        $this->_page = 'home';

        $this->_classes = $this->model('Classes');
        $this->_classes->selectClasses(4);

        $this->_opinions = $this->model('ClientOpinions');
        $this->_opinions->selectOpinions(6);

        parent::__construct($this->_page);

        $this->view($this->_page, $this->_path, [
            'navPages' => $this->_navPages,
            'pageDetails' => $this->_pageDetails,
            'classes' => $this->_classes->getData(),
            'opinions' => $this->_opinions->getData()
        ]);
    }

    public function index()
    {
        // Home banner used instead of standard banner
        $includeStandardBanner = false;

        $this->_view->renderView($includeStandardBanner);
    }
}
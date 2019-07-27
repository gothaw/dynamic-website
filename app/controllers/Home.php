<?php

class Home extends Controller
{
    private $_page;
    private $_classes = null;
    private $_opinions = null;

    /**
     *                          Home constructor.
     * @desc                    Constructor for the home page.
     *                          Instantiates view with classes, client opinions, navigation bar and this page data.
     */
    public function __construct()
    {
        $this->_page = 'home';

        $this->_classes = $this->model('Classes')->selectClasses(4);

        $this->_opinions = $this->model('ClientOpinions')->selectOpinions(6);

        parent::__construct($this->_page);

        $this->view($this->_page, $this->_path, [
            'navPages' => $this->_navPages,
            'pageDetails' => $this->_pageDetails,
            'classes' => $this->_classes->getData(),
            'opinions' => $this->_opinions->getData()
        ]);
    }

    /**
     *                          index
     * @desc                    Default method for home page. Renders home page view.
     */
    public function index()
    {
        // Home banner used instead of standard banner
        $includeStandardBanner = false;

        $this->_view->renderView($includeStandardBanner);
    }
}
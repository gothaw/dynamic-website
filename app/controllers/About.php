<?php

class About extends Controller
{
    private $_page;
    private $_classes;
    private $_coaches;

    /**
     *                          About constructor.
     * @desc                    Constructor for about page controller. Instantiates classes and coaches models and selects data from the database.
     *                          Instantiates view with classes, coaches, navigation bar and this page data.
     */
    public function __construct()
    {
        $this->_page = 'about';

        $this->_classes = $this->model('Classes')->selectClasses();

        $this->_coaches = $this->model('Coaches')->selectCoaches();

        parent::__construct($this->_page);

        $this->view($this->_page, $this->_path, [
            'navPages' => $this->_navPages,
            'pageDetails' => $this->_pageDetails,
            'classes' => $this->_classes->getData(),
            'coaches' => $this->_coaches->getData()
        ]);
    }

    /**
     * @method              index
     * @desc                Default controller method. Renders about page view.
     */
    public function index()
    {
        $this->_view->renderView();
    }
}
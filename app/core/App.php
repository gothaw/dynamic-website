<?php

class App
{
    private $_controller = 'home';
    private $_method = 'index';
    private $_parameters = [];

    /**
     *                          App constructor.
     * @desc                    Main app constructor. It uses parseUrl method to get an $url array.
     *                          It uses simple routing, where the first element of the array is a controller in controllers folder and
     *                          the second is a method in that controller e.g index or login. The rest of array element are parameters passed to the controller.
     *                          It calls the callback with given controller, method and parameters using call_user_func_array.
     */
    public function __construct()
    {
        $url = $this->parseUrl();

        if (file_exists('../app/controllers/' . $url[0] . '.php')) {
            $this->_controller = $url[0];
            unset($url[0]);
        }

        require_once '../app/controllers/' . $this->_controller . '.php';

        $this->_controller = new $this->_controller;

        if (isset($url[1])) {
            if (method_exists($this->_controller, $url[1])) {
                $this->_method = $url[1];
                unset($url[1]);
            }
        }

        $this->_parameters = $url ? array_values($url) : [];
        call_user_func_array([$this->_controller, $this->_method], $this->_parameters);
    }

    /**
     * @method                  parseUrl
     * @desc                    Explodes url after public folder. It also sanitizes url using filter_var.
     * @return                  array
     */
    private function parseUrl()
    {
        if (isset($_GET['url'])) {
            return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }
}
<?php

/**
 *                              Class App
 * @desc                        Core class of the app that uses simple routing based on the url provided.
 *                              The url is based on the rewrite base in .htaccess file. The url: controller/method/parameter-1/parameter-2/.../parameter-n
 *                              It uses callback function with given controller, method and parameter array.
 */
class App
{
    private $_controller = 'home';
    private $_method = 'index';
    private $_parameters = [];

    /**
     *                          App constructor.
     * @desc                    Main app constructor. It uses parseUrl method to get an $url array.
     *                          It implements simple routing, where the first element of the array is a controller in controllers folder and
     *                          the second is a method in that controller e.g index or login. The rest of array element are parameters passed to the controller.
     *                          It uses the callback with given controller, method and parameters using call_user_func_array.
     */
    public function __construct()
    {
        $url = $this->parseUrl();

        if (isset($url[0]) && file_exists('./app/controllers/' . $this->toPascalCase($url[0]) . '.php')) {
            $this->_controller = $this->toPascalCase($url[0]);
            unset($url[0]);
        }

        require_once './app/controllers/' . $this->toPascalCase($this->_controller) . '.php';

        $this->_controller = new $this->_controller;


        if (isset($url[1]) && method_exists($this->_controller, $this->toCamelCase($url[1]))) {
            try {
                $reflection = new ReflectionMethod($this->_controller, $this->toCamelCase($url[1]));
                if ($reflection->isPublic()) {
                    $this->_method = $this->toCamelCase($url[1]);
                    unset($url[1]);
                }
            } catch (ReflectionException $e) {
                // Redirect to error page.
                Redirect::to(404);
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
        return null;
    }

    /**
     * @method                  toPascalCase
     * @param                   $string {string-in-lisp-case}
     * @desc                    Converts lisp-case string to PascalCase.
     * @return                  string
     */
    private function toPascalCase($string)
    {
        return str_replace('-', '', ucwords($string, '-'));
    }

    /**
     * @method                  toCamelCase
     * @param                   $string {string-in-lisp-case}
     * @desc                    Converts lisp-case string to camelCase.
     * @return                  string
     */
    private function toCamelCase($string)
    {
        $str = $this->toPascalCase($string);
        $str[0] = strtolower($str[0]);
        return $str;
    }
}
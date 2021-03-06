<?php

// Require functions
require_once 'functions/functions.php';

// Require config files
require_once 'config/config.php';

// Autoload require for core classes
spl_autoload_register(function ($class) {

    if (file_exists('./app/core/' . $class . '.php')) {
        require_once './app/core/' . $class . '.php';
    }

});
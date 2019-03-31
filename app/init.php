<?php

// Require functions
require_once 'functions/functions.php';

// Require config files
require_once 'config/config.php';
require_once 'config/composer-config.php';


// Autoload require for core classes
spl_autoload_register(function ($class) {
    require_once 'core/' . $class . '.php';
});

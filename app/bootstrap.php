<?php
// load config
require_once 'config/config.php';
// load libraries
// require_once 'libraries/core.php';
// require_once 'libraries/controller.php';
// require_once 'libraries/database.php';

// Autoload core libraries; required that file names match the class name definition
spl_autoload_register(function($className) {
  require_once 'libraries/' . $className . '.php';
});
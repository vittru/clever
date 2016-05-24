<?php

error_reporting (E_ALL);

if (version_compare(phpversion(), '5.1.0', '<') == true) { die ('PHP5.1 Only'); }

define ('DIRSEP', DIRECTORY_SEPARATOR);

$site_path = realpath(dirname(__FILE__) . DIRSEP . '..' . DIRSEP) . DIRSEP;
define ('site_path', $site_path);

function __autoload($class_name) {
    $filename = strtolower($class_name) . '.php';
    $file = site_path . 'classes' . DIRSEP . $filename;
    if (file_exists($file) == false) {
            return false;
    }
    include ($file);
}

$registry = new Registry;

$logger = new Logging();
$logger->lfile('logs/clever.log');

$registry->set('logger', $logger);

if (isset($_COOKIE['userId'])) {
    $registry->set('userId', $_COOKIE['userId']);
}    
else {
    $registry['logger']->lwrite('Cookie is not set');
    $registry->set('userId', "");
}


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

function getBaseUrl() 
{
 // output: /myproject/index.php
 $currentPath = $_SERVER['PHP_SELF']; 
 
 // output: Array ( [dirname] => /myproject [basename] => index.php [extension] => php [filename] => index ) 
 $pathInfo = pathinfo($currentPath); 
 
 // output: localhost
 $hostName = $_SERVER['HTTP_HOST']; 
 
 // output: http://
 $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://';
 
 // return: http://localhost/myproject/
 return $protocol.$hostName.$pathInfo['dirname']."/";
}

$registry = new Registry;
$baseurl = getBaseUrl();

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


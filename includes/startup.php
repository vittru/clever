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
    $currentPath = $_SERVER['PHP_SELF']; 
    $pathInfo = pathinfo($currentPath); 
    $hostName = $_SERVER['HTTP_HOST']; 
    $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://';
    return $protocol.$hostName.$pathInfo['dirname']."/";
}

$registry = new Registry;
$baseurl = getBaseUrl();

$logger = new Logging();
$logger->lfile('logs/clever.log');

$registry->set('logger', $logger);


$registry->set('dbname', 'clubclever');
$registry->set('dbuser', 'root');
$registry->set('dbpassword', 'root');
$registry->set('mainemail', 'vitaly.trusov@gmail.com');

session_start();

if (isset($_COOKIE['user'])) {
    $userId=$_COOKIE['user'];
}    
else {
    $userId="";
};

if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = new User($userId);
} else {
    $_SESSION['user']->id = $userId;
}    
<?php


Class Router {

        private $registry;
        private $path;
        private $args = array();

        function __construct($registry) {
                $this->registry = $registry;
        }

        function setPath($path) {
            $path = rtrim($path, '/\\');
            $path .= DIRSEP;
            if (is_dir($path) == false) {                
                $this->registry['logger']->lwrite('Invalid controller path: `' . $path . '`');
            }
            $this->path = $path;
        }

    function delegate() {
        $this->getController($file, $controller, $action, $args);
        include ($file);
        $class = 'Controller_' . $controller;
        $controller = new $class($this->registry);
        if (is_callable(array($controller, $action)) == false) {
            $file = $this->path . '404.php';
            include($file);
            $action = 'index';
            $class = 'Controller_404';
            $controller = new $class($this->registry);
        }
        $controller->$action();
    }    
        
    private function getController(&$file, &$controller, &$action, &$args) {
        $route = (empty($_GET['route'])) ? '' : $_GET['route'];
        if (empty($route)) { $route = 'index'; }
        $route = trim($route, '/\\');
        $parts = explode('/', $route);
        $cmd_path = $this->path;
        foreach ($parts as $part) {
            $fullpath = $cmd_path . $part;
            if (is_dir($fullpath)) {
                $cmd_path .= $part . DIRSEP;
                array_shift($parts);
                continue;
            }
            if (is_file($fullpath . '.php') || is_file($fullpath)) {
                $controller = pathinfo($part, PATHINFO_FILENAME);
                array_shift($parts);
                break;
            }
        }

        if (empty($controller)) { $controller = 'index'; };

        $action = array_shift($parts);
        if (empty($action)) { $action = 'index'; }
        $file = $cmd_path . $controller . '.php';
        $args = $parts;
    }
}



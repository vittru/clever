<?php


Class Template {

    private $registry;
    private $vars = array();

    function __construct($registry) {
        $this->registry = $registry;
    }
        
    function set($varname, $value, $overwrite=false) {
        if (isset($this->vars[$varname]) == true AND $overwrite == false) {
            //$this->registry['logger']->lwrite('Unable to set var `' . $varname . '`. Already set, and overwrite not allowed.');
            return false;
        }
        $this->vars[$varname] = $value;
        return true;
    }    


    function remove($varname) {
        unset($this->vars[$varname]);
        return true;
    }

    function show($name) {
        $path = site_path . 'templates' . DIRSEP . $name . '.php';
        if (file_exists($path) == false) {
            $this->registry['logger']->lwrite('Template `' . $name . '` does not exist.');
            return false;
        }

        // Load variables
        foreach ($this->vars as $key => $value) {
                $$key = $value;
        }
        include ($path);                
    }
}





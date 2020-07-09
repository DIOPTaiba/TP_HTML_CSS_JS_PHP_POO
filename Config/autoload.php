<?php

class Autoloader
{
    static function register()
    {
        spl_autoload_register(array(__CLASS__,"autoload"));
    }
    static function autoload($class)
    {
        //echo $class;
        if(file_exists("../Model/".$class.".php"))
        {
            require_once "../Model/".$class.".php";
        }
        else if(file_exists("../Controller/".$class.".php"))
        {
            require_once "../Controller/".$class.".php";
        }
        
    }
}
Autoloader::register();

?>
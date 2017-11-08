<?php

namespace mf\utils;
class ClassLoader
{
    private $prefix;
    
    public function __construct($dir){
        $this->prefix = $dir;
    }
    
    
    function loadClass($classe){
        $str = $this->prefix.DIRECTORY_SEPARATOR;
        $str.= str_replace('\\',DIRECTORY_SEPARATOR,$classe);
        $str.= ".php";
        if(file_exists($str)){
            require_once $str;
        }
    }
    
    function register(){
        spl_autoload_register([$this,'loadClass']);
    }
}


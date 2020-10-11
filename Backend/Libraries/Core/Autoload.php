<?php
spl_autoload_register(function($class){
    if(file_exists("Backend/Libraries/".'Core/'.$class.".php")){
        require_once("Backend/Libraries/".'Core/'.$class.".php");
    }
});

?>
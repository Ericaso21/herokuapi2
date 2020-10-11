<?php

    class Api
    {
        function getApi($controller,$api,$data="")
        {
            $controller = get_class($controller);
            if($controller == "Home"){
                $api = $_SERVER['DOCUMENT_ROOT']."/parkingsoft-frontend/Views/".$api.".php";
            }else{
                $api = $_SERVER['DOCUMENT_ROOT']."/parkingsoft-frontend/Views/".$controller."/".$api.".php"; 
            }
            require_once ($api);
        }
    }
?>
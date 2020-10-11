<?php

    class Controllers
    {
        public function __construct()
        {
            $this->api = new Api();
            $this->loadModel();
        }

        public function loadModel()
        {
            $model = get_class($this)."Model";
            $routClass = "Backend/Models/".$model.".php";
            if(file_exists($routClass)){
                require_once($routClass);
                $this->model = new $model();
            }
        }
    }

?>
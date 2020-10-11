<?php

    class Errors extends Controllers{
        public function __construct()
        {
            parent::__construct();
        }

        public function notFound()
        {
            $this->api->getApi($this,"error");
        }

    }

    $notFound = new Errors();
    $notFound->notFound();

?>
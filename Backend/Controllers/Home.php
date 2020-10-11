<?php

    class Home extends Controllers{
        public function __construct()
        {
            parent::__construct();
        }

        public function home()
        {
            $data['page_id'] = 1;
            $data['page_tag'] = "Login";
            $data['page_title'] = "Admin";
            $data['page_name'] = "Parkingsoft";
            $this->api->getApi($this,"home",$data);
        }

    }

?>
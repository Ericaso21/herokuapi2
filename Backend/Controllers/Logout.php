<?php
    class Logout
    {
        public function _construct()
        {
            session_start();
            session_unset();
            session_destroy();
            header('location: http://localhost/pruebahtml/index.html');
        }
    }
?>
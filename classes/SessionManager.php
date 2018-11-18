<?php
    class SessionManager{
        private $defaultName = "SESSBISQUIT";
        private $defaultLifeTime = 0;
        private $defaultPath = "/";
        // $_SERVER['SERVER_NAME'];
        private $defaultDomain = "";
        //WARNING !
        private $defaultSecure = false;
        private $defaultHttpOnly = true;
        private $defaultSameSite = "lax";
        
        function __construct($lifeTime = null){
            if(!$lifeTime)$lifeTime = $this->defaultLifeTime;
            session_name($this->defaultName);
            session_set_cookie_params(
               $lifeTime,
               $this->defaultPath,
               $this->defaultDomain,
               $this->defaultSecure,
               $this->defaultHttpOnly
               //array("samesite" => $this->defaultSameSite)
            );
            session_start();
            
            //prevent session fixation attacks, by changing the cookie id if the user is trying to
            //connect using a cookie id that is not recognized
            if(!isset($_SESSION['__id_is_old'])){
               $_SESSION['__id_is_old'] = true;
               if(isset($_COOKIE[$this->defaultName])) session_regenerate_id(true);
            }
        }
        
        
        public function validate(){
            $_SESSION['__is_valid'] = true;
        }
        public function isValid(){
            return isset($_SESSION['__is_valid']);
        }
    }
?>
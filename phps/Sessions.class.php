<?php
    class SessionsManager{
        private $sessionDomain;
        private $httpOnly = true;
        function __construct($sessionName,$sessionLifeTime,$sessionPath = '/',$secure = false){
            session_name($sessionName.'_Session');
            $this->sessionDomain = isset($this->sessionDomain) ? $this->sessionDomain : $_SERVER['SERVER_NAME'];
            session_set_cookie_params($sessionLifeTime,'/',$this->sessionDomain,$secure,$this->httpOnly);
        }
        public function sessionCreate($idAccount,$username,$email){
            $_SESSION['valid'] = true;
            $_SESSION['idAccount'] = $idAccount;
            $_SESSION['username'] = $username;
        }
        public function sessionValidityControl(){
            session_start();
            if(isset($_SESSION['valid'])){
                return[$_SESSION['idAccount'],$_SESSION['username']];
            }
            else{
                return false;
            }       
        }
    }
?>
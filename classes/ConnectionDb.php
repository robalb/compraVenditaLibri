<?php
class ConnectionDb{
    private $dbDatas = array("localhost","root","1234");
    private $connectionLink;
    private $stmt;
    private $error;
    function __construct($dbName){
        $this->connectionLink = new mysqli($this->dbDatas[0],$this->dbDatas[1],$this->dbDatas[2],$dbName); 
    }
    public function standardUserRegistration($username,$email,$university,$password,$phoneNumber = null){
        $this->stmt = $this->connectionLink->stmt_init();
        //validating the variables
        ((strlen($username) >= 2 && strlen($username) <= 30) ? $error = 0 : $error = 1 );//input data error
        ((filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email) < 150) ? $error = 0 : $error = 1);
        ((strlen($password) >= 12 && strlen($password) <= 40) ? $error = 0 : $error = 1);
        if($phoneNumber != null){
            ((strlen($phoneNumber) === 10) ? $error = 0 : $error = 1);
        }
        if($error != 0) return $error;
        //sanitizing the variables
        $username = filter_var($username,FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_ENCODE_HIGH);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $university = filter_var($university,FILTER_SANITIZE_NUMBER_INT);
        $password = password_hash($password,PASSWORD_BCRYPT);
        //checking if the mail is not already used
        $mailStatus = mailSearch();
        //generating a valid user id
        do{
            $idAccount = random_int(1000000000,9999999999);
            $valid = $this->validateId($idAccount);
        }while($valid == 1);
        if($error != 2){
            return 2; //return the internal error, pretty rare i know but no one never know what can happen to the server so i think its a good idea
        }
        //preparing the preconstructed queries

        $this->stmt->prepare('insert into Accounts (AccountId,Name,Password,Email,PhoneNumber,UniversityOrInstitute) values (?,?,?,?,?,?)'); 
        //binding the parameters
        $this->stmt->bind_param("isssii",
            $idAccount,
            $username,
            $password,
            $email,
            $phoneNumber,
            $university
        ); 
        $this->stmt->execute();
        if($this->stmt->error){
            echo $this->stmt->error;
            return 2; //internal error
        }
        $this->stmt->close();
        return ;
    }

    private function validateId($idAccount){
        $this->connectionLink->query('select RegistrationDate from Accounts where AccountId ="'.$idAccount.'" limit 1 ;');
        if($this->connectionLink->errno){
            echo $this->connectionLink->error;
            return 2; //this mean that there was an internal error
        }
        else{
            return $this->connectionLink->affected_rows;
        }
    }
    private function mailSearch($mail){
        $this->stmt->prepare('select ...');
    } 
    function __destruct(){
        $this->connectionLink->close(); 
    }
};
?>
<?php
include_once("./functions/utilities.php");
include_once("./functions/phpMailer.php");
/*
errors index:
.1 = invalid datas
.2 = internal error
.3 = mail not validated
.4 = mail already registered
*/
class ConnectionDb{
    private $dbDatas = array('localhost','root','1234');
    private $connectionLink;
    private $stmt;
    private $error;
    function __construct($dbName){
        $this->connectionLink = new mysqli($this->dbDatas[0],$this->dbDatas[1],$this->dbDatas[2],$dbName); 
    }
    public function standardUserRegistration($username,$email,$password,$instRegionId,$instProvinceId,$instCityId,$instId,$phoneNumber = null){
        //validating the variables
        ((strlen($username) >= 2 && strlen($username) <= 30) ? $error = 0 : $error = 1 );//input data error
        ((filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email) < 150) ? $error = 0 : $error = 1);
        ((strlen($password) >= 8 && strlen($password) <= 40) ? $error = 0 : $error = 1);
        if($phoneNumber != null){
            ((strlen($phoneNumber) === 10) ? $error = 0 : $error = 1);
        }
        if($error != 0) return $error;
        //sanitizing the variables
        $username = filter_var($username,FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_ENCODE_HIGH);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $email = emailAliasDelete($email);        
        $instId = filter_var($instId,FILTER_SANITIZE_NUMBER_INT);
        $instCityId = filter_var($instCityId,FILTER_SANITIZE_NUMBER_INT);
        $instProvinceId = filter_var($instProvinceId,FILTER_SANITIZE_NUMBER_INT);
        $instRegionId = filter_var($instRegionId,FILTER_SANITIZE_NUMBER_INT);
        $password = password_hash($password,PASSWORD_BCRYPT);
        //checking if the mail is not already used
        $validMail = $this->emailSearch($email);
        if($validMail == 2) return 4;
        else if($validMail == 1) return 3;
        //generating a valid user id
        do{
            $idAccount = random_int(1000000000,9999999999);
            $error = $this->validateId($idAccount);
        }while($error == 1);
        if($error != 0) return $error;
        //preparing the preconstructed queries
        $this->stmt = $this->connectionLink->stmt_init();
        $this->stmt->prepare('insert into Accounts (AccountId,Name,Password,Email,PhoneNumber,InstId,InstCityId,InstProvinceId,InstRegionId) values (?,?,?,?,?,?,?,?,?)'); 
        //binding the parameters
        $this->stmt->bind_param('isssiiiii',
            $idAccount,
            $username,
            $password,
            $email,
            $phoneNumber,
            $instId,
            $instCityId,
            $instProvinceId,
            $instRegionId
        ); 
        $this->stmt->execute();
        if($this->stmt->error){
            return 2; //internal error
        }
        $this->stmt->close();
        return 0;
    }
    public function emailCreateValidation($email){
        // standard preconstructed query initialization
        $this->stmt = $this->connectionLink->stmt_init();
        // preparing datas
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $email = emailAliasDelete($email);
        $validationToken = bin2hex(random_bytes(16));
        // prepairing query
        $this->stmt->prepare('insert into MailsValidation (ConfirmationId , Mail) values (?,?)');
        $this->stmt->bind_param('ss',$validationToken,$email);
        $this->stmt->execute();
        if($this->stmt->error){
            $this->stmt->close();
            return 2;
        }
        // closing stmt
        $this->stmt->close();
        //  preparing the message text
        $argument = 'ph reg';
        $content = 'pay 100 dollars in 2 days.'.$validationToken;
        sendEmail($email,$argument,$content);
        return 0;
    }
    private function emailSearch($email){
        $this->stmt = $this->connectionLink->stmt_init();
        $this->stmt->prepare('select EmailValidation from Accounts where Email = ? limit 1');
        $this->stmt->bind_param('s',$email);
        $this->stmt->execute();
        $this->stmt->store_result();
        $this->stmt->bind_result($valid);
        if($this->stmt->num_rows == 0){
            return 0;
        }
        $this->stmt->fetch();
        $this->stmt->close();
        if($valid == 1){
            return 2; //validated mail
        }
        else{
            return 1; //not validated mail 
        }
    } 
    private function validateId($idAccount){
        $this->connectionLink->query('select RegistrationDate from Accounts where AccountId ="'.$idAccount.'" limit 1 ;');
        if($this->connectionLink->errno){
            echo $this->connectionLink->error;
            return 2; //this mean that there was an internal error
        }
        else{
            //return 1 or 0 depend if the id already exist or not
            return $this->connectionLink->affected_rows;
        }
    }
    function __destruct(){
        $this->connectionLink->close(); 
    }
};
?>
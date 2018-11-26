<?php
    include_once("./classes/SessionManager.php");
    include_once("./classes/ConnectionDb.php");
    include_once("./functions/utilities.php");
    include_once("./functions/phpMailer.php");
    $session = new SessionManager('RealSession',1000);
    $mysqli = new ConnectionDb('tests');
    if($session->isValid()){
        
    }
    else if(isset($_POST['action'])){
        /*
            errors index:
            .1 = invalid datas
            .2 = internal error
            .3 = mail not validated
            wsfsg.4 = mail already registered
        */
        if($_POST['action'] == 'register'){
            $error = $mysqli->standardUserRegistration(
                $_POST['username'],
                $_POST['email'],
                $_POST['password'],
                $_POST['regionId'],
                $_POST['provinceId'],
                $_POST['cityId'],
                $_POST['instId']
            );
            if($error == 0){
                $error = $mysqli->emailCreateValidation($_POST['email']);
            }
        }
    }
    else{
        echo 'null';
    }
?>
<htlm>
    <head>
        <meta  charset="UTF-8">
    </head>
    <body>
        <?php
            if(isset($error)){
                echo ("<label>$error<label>");
            }
        ?>
        <form id="registration" action="registration.php" method="POST"> 
            <label>Registration</label></br>
            <label>Nome:</label></br>
            <input type="text" id="input_txt" name="username"/></br>
            <label>Email:</label></br>
            <input type="email" id="input_txt" name="email"/></br>
            <label>Universita o istituto</label>
            <select name="regionId" id="input_slct">
                <option value="01">Lombardia</option>
            </select></br>
            <select name="provinceId" id="input_slct">
                <option value="001">Monza e Brianza</option>
            </select></br>
            <select name="cityId" id="input_slct">
                <option value="01">Monza</option>
            </select></br>
            <select name="instId" id="input_slct">
                <option value="0001">Hensemberger</option>
            </select></br>
            <label>Password:</label></br>
            <input type="password" id="input_txt" name="password"/></br>
            <input type="hidden" name="action" value="register"/>
            <input type="submit" id="input_butt">
        </form>
    </body>
</html>
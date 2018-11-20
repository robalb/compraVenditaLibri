<?php
    include_once("./classes/SessionManager.php");
    include_once("./classes/ConnectionDb.php");
    $session = new SessionManager('RealSession',1000);
    $mysqli = new ConnectionDb('tests');
    if($session->isValid()){
        
    }
    else if(isset($_POST['action'])){
        if($_POST['action'] == 'register'){
            $error = $mysqli->standardUserRegistration(
                $_POST['username'],
                $_POST['email'],
                $_POST['university'],
                $_POST['password']
            );
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
            <select name="university" id="input_slct">
                <option value="123456">Hensemberger</option>
            </select></br>
            <label>Password:</label></br>
            <input type="password" id="input_txt" name="password"/></br>
            <input type="hidden" name="action" value="register"/>
            <input type="submit" id="input_butt">
        </form>
    </body>
</html>
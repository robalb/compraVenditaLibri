<?php
    include_once("./classes/SessionManager.php");
    //include_once("./phps/ConnectionDb.class.php");
    $session = new SessionManager('RealSession',1000);
    if($session->isValid()){
        echo $_SESSION['username'];
        echo $_SESSION['email'];
        echo $_SESSION['universitaOIstituto'];
        echo $_SESSION['password'];
    }
    else if(isset($_POST['action'])){
        if($_POST['action'] == 'register'){
            
            //rimando all index da aggiungere in seguito
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
                echo ("<label> $error <label>");
            }
        ?>
        <h2>
        <form id="registration" action="LorR.php" method="POST"> 
            <label>Registration</label>
            <label>Nome:</label></br>
            <input type="text" id="input_txt" name="username"/></br>
            <label>Email:</label></br>
            <input type="email" id="input_txt" name="email"/></br>
            <label>Universita o istituto</label>
            <select name="university" id="input_slct">
                <option value="Hensemberger">Hensemberger</option>
            </select></br>
            <label>Password:</label></br>
            <input type="password" id="input_txt" name="password"/></br>
            <input type="hidden" name="action" value="register"/>
            <input type="submit" id="input_butt">
        </form>
    </body>
</html>
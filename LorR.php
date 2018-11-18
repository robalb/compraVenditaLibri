<?php
    include_once("./phps/Sessions.class.php");
    include_once("./phps/ConnectionDb.class.php");
    $session = new SessionsManager('RealSession',1000);
    if($session->sessionValidityControl()){
        //session already exist
    }
    else{
        if($_POST['action'] == 'login'){
            //call the SANITIZETOR  
        }
        if($_POST['action'] == 'register'){
            //call the SANITIZETOR
        }
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
            Login
        </h2>
        <form id="login" action="LorR.php" method="POST" >
            <label>Login</label>
            <input type="text" id="username" name="username"/>
            <br/>
            <br/>
            <label>password</label>
            <input type="password" id="password" name="password"/>
            <input type="text" value="login" id="action" name="action" style="display:none"/>
            <input type="submit" value="invio">
        </form>
        <form id="registration" action="LorR.php?action=registration" method="POST" style="display:none"> <!--display:none-->
            <label>Registration</label>
            <input type="text" id="username"/>
            <!-- dude, potresti mettere qi la parte di registrazione che si puo scambiare grazie a js con quella di login premendo un semplice link?-->
        </form>
    </body>
</html>
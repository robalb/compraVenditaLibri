<?php
    /*session class demo */
    include_once("./classes/SessionManager.php");
    
    //crea la sessione
    $session = new SessionManager();
    if($session->isValid()){
      //se la sessione non è nuova, quindi se l'user e' loggato -> mostra il suo nome
      echo "WELCOME BACK ";
      echo $_SESSION['name'];
      
    }else{
       //altrimenti, se la sessione è nuova -> salva il nome dell utente
      $session->validate();
      echo "WELCOME ";
      if(isset($_GET['name'])){
         $_SESSION['name'] = htmlspecialchars($_GET['name']);
         echo $_GET['name'];
      }else{
         $_SESSION['name'] = "anonimo";
         echo "NEW USER. <br> non hai detto il tuo nome tramite parametro get[name], quindi ti &egrave; stato assegnato il nome di anonimous";
      }
      echo "<br>this is the first time you visit the website";
    }

?>
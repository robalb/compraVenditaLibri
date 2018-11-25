<?php
    //variables zone
    $dbName = 'tests';
    $email = 'bellcranel480@gmail.com';
    //constant initialization
    $sql = new mysqli('localhost','root','1234',$dbName);
    $stmt = $sql->stmt_init();
    $stmt->prepare('select EmailValidation from Accounts where Email = ?');
    //code
    $stmt->bind_param('s',$email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($valid);
    echo $stmt->num_rows;
    $stmt->fetch();
    echo $valid;
    //constant destruction
    $stmt->close();
    $sql->close();
?>

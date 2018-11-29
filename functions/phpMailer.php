<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    function sendEmail($receiver,$argument,$content,$noHtmlContent){
        require_once './libraries/PHPMailer/Exception.php';
        require_once './libraries/PHPMailer/PHPMailer.php';
        require_once './libraries/PHPMailer/SMTP.php';
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = '';                 // SMTP username
            $mail->Password = 'Spotorno11';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('Debug@compraVenditaLibri.com', 'Debug');
            $mail->addAddress($receiver);               // receiver
            $mail->addReplyTo('info@example.com', 'Information');
            $mail->addCC('');
            $mail->addBCC('');

            //Attachments
            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $argument;
            $mail->Body    = $content;
            $mail->AltBody = $noHtmlcontent;

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo $receiver;             
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    }
?>
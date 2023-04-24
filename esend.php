<?php

    include "register2.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/SMTP.php';

    
    try 
    {
        
        $mail = new PHPMailer(true);

        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = 'whitehatech@gmail.com';                     //SMTP username
        $mail->Password = 'yxxgjfgzazxwrdyv';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port = 465;

        $mail->setFrom("whitehatech@gmail.com");
        $mail->addAddress("$email");

        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'OTP Code';
        $mail->Body = 'Hello there';

        $mail->send();
        echo 'Message has been sent';
            
    }
    catch (Exception $e)
    {
        echo "hello $email";
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

?>

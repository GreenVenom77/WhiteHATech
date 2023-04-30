<?php

    include "conn.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/SMTP.php';

    if(isset($_POST['u_name']) && isset($_POST['email']) && isset($_POST['user_pass']))
    {

        function validate($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $u_name = validate($_POST['u_name']);
        $email = validate($_POST['email']);
        $user_pass = validate($_POST['user_pass']);

        if(empty($u_name) || empty($user_pass) || empty($email))
        {
            header("Location: register2.php?error=User Name, password and Email are required");
            exit();
        }
        else
        {
            $otp_str = str_shuffle("0123456789");
            $otp = substr($otp_str, 0, 6);
            $sql2 = "INSERT INTO users(u_name, user_pass,verification_code, email) VALUES ('$u_name', '$user_pass', '$otp', '$email');";
            $res = pg_query($con,$sql2);
            if($res)
            {
                $mail = new PHPMailer(true);
            
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth = true;                                   //Enable SMTP authentication
                $mail->Username = 'whitehatech@gmail.com';                     //SMTP username
                $mail->Password = 'yxxgjfgzazxwrdyv';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port = 465;
            
                $mail->setFrom('whitehatech@gmail.com');
                $mail->addAddress($email);
            
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'OTP Code';
                $mail->Body = 'Hello there, Your OTP is: '.$otp;
            
                $mail->send();
                echo 
                "
                    <script>
                        alert('the OTP has been sent to your E-Mail');
                        document.location.href = 'otp_verify.php';
                    </script>
                ";
            }
        }
    }
    
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Signup</title>
        <link rel="stylesheet" type="text/css" href="Assets/css/lr.css">
    </head>
    <body>
        <form method="post">
            <a href="index.php" class="Logo">
            <img src="Assets/imgs/Logow2.png" alt="Logo">
            </a>
            <h2>Signup</h2>
            <label>User Name:</label>
            <input type="text" name="u_name" required> <br>
            <label>Email:</label>
            <input type="email" name="email" required> <br>
            <label>Password:</label>
            <input type="password" name="user_pass" required> <br>
            <input class="butn" type="submit" name="submit_done"> <br>
        </form>
    </body>
</html>

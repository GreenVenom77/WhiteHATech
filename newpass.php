<?php

    session_start();

    include "conn.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/SMTP.php';

    if(isset($_POST['password']))
    {
        function validate($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $password = validate($_POST['password']);

        if(empty($password))
        {
            header("Location: newpass.php?error=Password is required");
            exit();
        }
        else
        {
            $email = $_SESSION['email'];

            $sql=("UPDATE users SET user_pass= '$password' WHERE email= '$email'");
            $result = pg_query($con,$sql);

            $row = pg_fetch_assoc($result);
            if($row['user_pass'] === $password)
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
                $mail->Body = 'Hello there, Your Password has been changed successfully!';
            
                $mail->send();
                echo 
                "
                    <script>
                        alert('The Password has been changed successfully');
                        document.location.href = 'login.php';
                    </script>
                ";

                session_unset();
                session_abort();
            }
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>WhiteHATech</title>
        <link rel="icon" type="image/x-icon" href="Assets/imgs/logo2.ico">
        <link rel="stylesheet" type="text/css" href="Assets/css/lr.css">
    </head>
    <body>
        <form method="post">
            <a href="index.php" class="Logo">
            <img src="Assets/imgs/Logow2.png" alt="Logo">
            </a>
            <h2>Enter your new Password</h2>
            <label>New Password:</label>
            <input type="Password" name="password" required> <br>
            <input class="butn" type="submit" name="submit_done"> <br>
        </form>
    </body>
</html>

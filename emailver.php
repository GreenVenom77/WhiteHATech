<?php

    session_start();

    include "conn.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/SMTP.php';

    if(isset($_POST['email']))
    {
        function validate($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $email = validate($_POST['email']);

        if(empty($email))
        {
            header("Location: emailver.php?error=Email is required");
            exit();
        }
        else
        {

            $sql=("SELECT * FROM users where email = '$email'");
            $result = pg_query($con,$sql);
            if(pg_num_rows($result) === 1)
            {
                $row = pg_fetch_assoc($result);
                if($row['email'] === $email)
                {
                    
                    $_SESSION['email'] = $row['email'];

                    $otp_str = str_shuffle("0123456789");
                    $otp = substr($otp_str, 0, 6);
                    $sql2=("UPDATE users SET verification_code= '$otp' WHERE email= '$email'");
                    $result2 = pg_query($con,$sql2);

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
                            document.location.href = 'otp_pass_verify.php';
                        </script>
                    ";
                }
            }
            else
            {
                header("Location: emailver.php?error=Incorrect Email");
                exit();
            }

        }

    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Reset Password</title>
        <link rel="stylesheet" type="text/css" href="Assets/css/lr.css">
    </head>
    <body>
        <form method="post">
            <a href="index.php" class="Logo">
            <img src="Assets/css/imgs/Logo.png" alt="Logo">
            </a>
            <h2>Enter your Email</h2>
            <label>Email:</label>
            <input type="email" name="email" required> <br>
            <input type="submit" name="submit_done"> <br>
        </form>
    </body>
</html>

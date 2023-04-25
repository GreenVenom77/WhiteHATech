<?php

    include "conn.php";

    if(isset($_POST['otpv']))
    {
        function validate($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $otpv = validate($_POST['otpv']);

        if(empty($otpv))
        {
            header("Location: otp_pass_verify.php?error=otp is required");
            exit();
        }
        else
        {
            $sql3=("SELECT * FROM users where verfication_code = '$otpv'");
            $result = pg_query($con,$sql3);
            if(pg_num_rows($result) === 1)
            {
                $row = pg_fetch_assoc($result);
                if($row['verfication_code'] === $otpv)
                {
                    $u_id = $row['u_id'];
                    $otpv = "0";
                    $sql4=("UPDATE users
                    SET verfication_code= '$otpv'
                    WHERE u_id = '$u_id';");
                    $result2 = pg_query($con,$sql4);

                    header("Location: newpass.php");
                }
            }
            else
            {
                header("Location: otp_verify.php?error=otp is wrong");
            }
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Verify</title>
        <link rel="stylesheet" type="text/css" href="Assets/css/lr.css">
    </head>
    <body>
        <form method="post">
            <a href="index.php" class="Logo">
            <img src="Assets/css/imgs/Logo.png" alt="Logo">
            </a>
            <h2>Verification</h2>
            <label>OTP:</label>
            <input type="text" name="otpv" required> <br>
            <input type="submit" name="submit_done"> <br>
        </form>
    </body>
</html>
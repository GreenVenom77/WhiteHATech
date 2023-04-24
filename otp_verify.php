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
            header("Location: otp_verify.php?error=otp is required");
            exit();
        }
        else
        {
            $sql3=("SELECT * FROM users where verfication_code = '$otpv'");
            $result = pg_query($con,$sql3);
            if(pg_num_rows($result) === 1)
            {
                $row = pg_fetch_assoc($result);
                if($row['verfication_code']=== $otpv)
                {
                    $u_name = $row['u_name'];
                    $otpv = "0";
                    $sql4=("UPDATE users
                    SET verfication_code= '$otpv'
                    WHERE u_name = '$u_name';");
                    $result2 = pg_query($con,$sql4);

                    header("Location: index.php");
                }
            }
            else
            {
                echo "Error";
            }
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Verify</title>
        <link rel="stylesheet" type="text/css" href="Assets/css/style.css">
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
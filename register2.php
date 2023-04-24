<?php
    include "conn.php";
    if(isset($_POST['u_name']) && isset($_POST['user_pass']))
    {

        function validate($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $u_name = validate($_POST['u_name']);

        $user_pass = validate($_POST['user_pass']);

        if(empty($u_name) || empty($user_pass) )
        {
            header("Location: register2.php?error=User Name and user password is required");
            exit();
        }
        else
        {
            $sql2 = "INSERT INTO users(
            u_name, user_pass)
            VALUES ('$u_name', '$user_pass');";
            $res = pg_query($con,$sql2);
            if($res)
            {
                header("Location: index.php");
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
        <title>Register 2</title>
        <link rel="stylesheet" type="text/css" href="Assets/css/style.css">
    </head>
    <body>
        <form method="post">
            <a href="index.php" class="Logo">
            <img src="Assets/css/imgs/Logo.png" alt="Logo">
            </a>
            <h2>Signup</h2>
            <label>User Name:</label>
            <input type="text" name="u_name"> <br>
            <label>Password:</label>
            <input type="text" name="user_pass"> <br>
            <input type="submit" name="submit_done"> <br>
        </form>
    </body>
</html>

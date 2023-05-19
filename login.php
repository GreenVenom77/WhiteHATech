<?php

    session_start();

    include "conn.php";

    if(isset($_POST['uname']) && isset($_POST['Password']))
    {
        function validate($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $uname = validate($_POST['uname']);
        $Pass = validate($_POST['Password']);

        if(empty($uname))
        {
            header("Location: login.php?error=User Name is required");
            exit();
        }
        else if(empty($Pass))
        {
            header("Location: login.php?error=Password is required");
            exit();
        }
        else
        {

            $sql=("SELECT * FROM users where u_name = '$uname' and user_pass='$Pass'");
            $result = pg_query($con,$sql);

            $sqla=("SELECT * FROM admin where user_name = '$uname' and password='$Pass'");
            $resulta = pg_query($con,$sqla);

            if(pg_num_rows($result) === 1)
            {
                $row = pg_fetch_assoc($result);
                if($row['u_name']===$uname && $row['user_pass']===$Pass)
                {
                    $_SESSION['user_name']=$row['u_name'];
                    $_SESSION['password']=$row['user_pass'];
                    $_SESSION['email']=$row['email'];
                    $_SESSION['user_id']=$row['u_id'];
                    header("Location: index.php");
                    exit();
                }
            }
            elseif(pg_num_rows($resulta) === 1)
            {
                $row = pg_fetch_assoc($resulta);
                if($row['user_name']===$uname && $row['password']===$Pass)
                {
                    $_SESSION['user_name']=$row['user_name'];
                    $_SESSION['password']=$row['password'];
                    header("Location:admin/adminHome.php");
                    exit();
                }
            }
            else
            {
                header("Location: login.php?error=Incorrect User name or Password");
                exit();
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
            <h2>Login</h2>
            <label>User Name</label>
            <input type="text" name="uname" placeholder="User Name"><br>
            <label>Password</label>
            <input type="Password" name="Password" placeholder="Password"><br>
            <button class="butn" type="submit">Login</button>
            <a href="emailver.php">Forgot Password?</a>
        </form>
    </body>
</html>
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
            if(pg_num_rows($result) === 1)
            {
                $row = pg_fetch_assoc($result);
                if($row['u_name']=== $uname && $row['user_pass']===$Pass)
                {
                    $_SESSION['user_name']=$row['u_name'];
                    $_SESSION['password']=$row['user_pass'];
                    header("Location: index.php");
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
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href="Assets/css/style.css">
    </head>
    <body>
        
        <form method="post">
            <a href="index.php" class="Logo">
            <img src="Assets/css/imgs/Logo.png" alt="Logo">
            </a>
            <h2>Login</h2>
            <?php if (isset($_GET['error'])){?>
                <p class ="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>
            <label>User Name</label>
            <input type="text" name="uname" placeholder="User Name"><br>

            <label>Password</label>
            <input type="Password" name="Password" placeholder="Password"><br>

            <button type="submit">Login</button>
        </form>
    </body>
</html>
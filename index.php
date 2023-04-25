<?php

    session_start();

    if(isset($_SESSION['password']) && isset($_SESSION['user_name']))
    {
        echo "<a href='logout.php'>Logout</a>";
        echo "Hello, ",$_SESSION['user_name'];
    }
    else
    {
        echo "<a href='login.php'>Login</a>";
        echo "<a href='register1.php'>Register</a>";
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
        <link rel="stylesheet" type="text/css" href="Assets/css/.css">
    </head>
    <body>

    </body>
</html>
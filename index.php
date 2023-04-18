<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="Assets/css/style.css">
</head>
<?php
    $myPDO = new PDO('pgsql:host=database-1.cxjhu3idchez.eu-north-1.rds.amazonaws.com; dbname=Grays', 'postgres', 'teamgrays');
    if(!$myPDO)
    {
        echo "connection failed";
    }
    else
    {
        echo "connection success";
    }
?>
<body>
    <form action="login.php" method="post">
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
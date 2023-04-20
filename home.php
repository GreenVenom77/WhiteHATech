<?php
session_start();
if(isset($_SESSION['password']) && isset($_SESSION['user_name'])){


?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="Assets/css/style.css">
</head>
<body>
    <h1>Hello, <?php echo $_SESSION['password']; ?></h1>
    <a href="logout.php">Logout</a>
</form>
</body>
</html>
<?php
}else{
    header("Location: index.php");
    exit();
}
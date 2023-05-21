<?php
    include "../conn.php"; 

    if(isset($_GET['delete'])){
        $delete_id = $_GET['delete'];
        pg_query($con,"UPDATE users SET  message=NULL WHERE u_id='$delete_id';") or  die('queury failed');
        header('location:adminMessages.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="x-UA-compatible" content="IE-edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="font/css/all.css">
        <link rel="stylesheet" href="style.css">
        <title>WhiteHaTech Store</title>
        <link rel="icon" type="image/x-icon" href="image/logo2.ico">
    </head>

    <body>
        <section id="header">
            <a href="#"><img src="image/logow2.png" class="logo" alt=""></a>
            <div>
                <ul id="navbar">
                    <li><a href="adminHome.php">Home</a></li>
                    <li><a href="admin_products.php">Products</a></li>
                    <li><a href="admin_users.php">Users</a></li>
                    <li><a href="orders.php">Orders</a></li>
                    <li><a class="active" href="adminMessages.php">Messages</a></li>
                    <li><i class="fa-solid fa-list" id="menu-btn"></i></li>
                    <li><i class="fa-solid fa-user" id="user-btn"></i></li>
                    <li><form method="post" action="certain.php"><input type="text" placeholder="Search..." name="search">
                    <button type="submit" name="submit"><i class="fa-solid fa-magnifying-glass"></i></button></form></li>
                </form></li>
                </ul>
            </div>
            <div class="user-box">
                <p>Username: <span><?Php echo $_SESSION['user_name']; ?></span></p>
                <form method="post" action="../logout.php" class="logout">
                    <button name="logout" class="logout-btn">LOG OUT</button>
                </form>
            </div>
        </section>
    <section class="user-container">
        <h1 class="title">Total Messages</h1>
        <div class="box-container">
            <?php 
            $select_users=pg_query($con,"SELECT u_id, u_name, email, message from users where message is not NULL") or die('query failed');
            if(pg_num_rows($select_users)>0)
            {
                while($fetch_users = pg_fetch_assoc($select_users))
                {

                    ?>
                <div class="box">
                    <p>User Id: <span><?php echo $fetch_users['u_id'] ; ?></span></p>
                    <p>User Name: <span><?php echo $fetch_users['u_name'] ; ?></span></p>
                    <p>Email: <span><?php echo $fetch_users['email'] ; ?></span></p>
                    <p>Message: <br><br><span><?php echo $fetch_users['message'] ; ?></span></p>
                    <a href="adminMessages.php?delete=<?php echo $fetch_users['u_id'];?>" class="delete" onclick="return confirm('Delete this?')">Delete</a>
                </div>
                <?php
                }
            }
            else
            {
                echo '<label class = "empty">There are no messages to show</label>';
            }
            ?>
        </div>
    </section>
    <script type ="text/javascript" src="script.js"></script>
    </body>
   <?php include "footer.php" ?> 
</html>
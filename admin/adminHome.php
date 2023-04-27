<?php
include "conn.php";
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
    </head>

    <body>
        
    <section id="header">
            <a href="#"><img src="image/logo.png" class="logo" alt=""></a>
            <div>
                <ul id="navbar">
                    <li><a class="active" href="adminHome.php">Home</a></li>
                    <li><a href="admin_products.php">Product</a></li>
                    <li><a href="admin_users.php">Users</a></li>
                    <li><a href="orders.php">Orders</a></li>
                    <li><i class="fa-solid fa-list" id="menu-btn"></i></li>
                    <li><i class="fa-solid fa-user" id="user-btn"></i></li>
                </ul>
            </div>
            <div class="user-box">
                <p>username: <span><?Php echo $_SESSION['user_name']; ?></span></p>
                <p>email: <span><?php echo $_SESSION['password']; ?></span></p>
                <form method="post" action="user/logout.php" class="logout">
                    <button name="logout" class="logout-btn">LOG OUT</button>
                </form>
            </div>
        </section>

        <section class="dashboard">
            <h1 class="title">dashboard</h1>
            <div class="box-container">
                <div class="box">
                    <?php
                    $total_pendings = 0;
                    $select_pendings = pg_query($con,"SELECT * FROM orders where payment_status = 'pending'")
                    or die('queury failed');
                    while($fetch_pendings = pg_fetch_assoc($select_pendings)){
                        $total_pendings += $fetch_pendings['total_price'];
                    }
                    ?>
                    <h3>$ <?php echo $total_pendings; ?></h3>
                    <p>total pendings</p>
                </div>
                <div class="box">
                    <?php
                    $total_completed = 0;
                    $select_completed = pg_query($con,"SELECT * FROM orders where payment_status = 'completed'")
                    or die('queury failed');
                    while($fetch_completed = pg_fetch_assoc($select_completed)){
                        $total_completed += $fetch_completed['total_price'];
                    }
                    ?>
                    <h3>$ <?php echo $total_completed; ?></h3>
                    <p>total completed</p>
                </div>
                <div class="box">
                    <?php
                    $select_orders = pg_query($con,"SELECT * FROM orders")
                    or die('queury failed');
                    $num_of_orders= pg_num_rows($select_orders);
                    ?>
                    <h3><?php echo $num_of_orders; ?></h3>
                    <p>order placed</p>
                </div>
                <div class="box">
                    <?php
                    $select_products = pg_query($con,"SELECT * FROM product")
                    or die('queury failed');
                    $num_of_products= pg_num_rows($select_products);
                    ?>
                    <h3><?php echo $num_of_products; ?></h3>
                    <p>products added</p>
                </div>
                <div class="box">
                    <?php
                    $select_users = pg_query($con,"SELECT * FROM users")
                    or die('queury failed');
                    $num_of_users= pg_num_rows($select_users);
                    ?>
                    <h3><?php echo $num_of_users; ?></h3>
                    <p>registered user</p>
                </div>
                <div class="box">
                    <?php
                    $select_admins = pg_query($con,"SELECT * FROM admin")
                    or die('queury failed');
                    $num_of_admins= pg_num_rows($select_admins);
                    ?>
                    <h3><?php echo $num_of_admins; ?></h3>
                    <p>admins</p>
                </div>
                <div class="box">
                    <?php
                    $select_users = pg_query($con,"SELECT * FROM users")
                    or die('queury failed');
                    $num_of_users= pg_num_rows($select_users);
                    ?>
                    <h3><?php echo $num_of_users; ?></h3>
                    <p>total user!!!</p>
                </div>
                <div class="box">
                    <?php
                    $select_users = pg_query($con,"SELECT * FROM users")
                    or die('queury failed');
                    $num_of_users= pg_num_rows($select_users);
                    ?>
                    <h3><?php echo $num_of_users; ?></h3>
                    <p>new message!!!</p>
                </div>
            </div>
        </section>
       <?php include 'footer.php' ?>
        <script src="script.js"></script>
    </body>
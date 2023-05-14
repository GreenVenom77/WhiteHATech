<?php 
    include "../conn.php";

    if(isset($_GET['delete']))
    {
        $delete_id = $_GET['delete'];
        pg_query($con, "DELETE FROM orders WHERE id = '$delete_id'") or die('query failed');
        header('location:orders.php');
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
    </head>

    <body>
        
    <section id="header">
            <a href="#"><img src="image/logow2.png" class="logo" alt=""></a>
            <div>
                <ul id="navbar">
                    <li><a href="adminHome.php">Home</a></li>
                    <li><a href="admin_products.php">Products</a></li>
                    <li><a  href="admin_users.php">Users</a></li>
                    <li><a class="active" href="orders.php">Orders</a></li>
                    <li><a href="adminMessages.php">Messages</a></li>
                    <li><i class="fa-solid fa-list" id="menu-btn"></i></li>
                    <li><i class="fa-solid fa-user" id="user-btn"></i></li>
                    <li><form method="post" action="certain.php"><input type="text" placeholder="Search..." name="search">
                    <button type="submit" name="submit"><i class="fa-solid fa-magnifying-glass"></i></button></form></li>
                </form></li>
                </ul>
            </div>
            <div class="user-box">
                <p>username: <span><?Php echo $_SESSION['user_name']; ?></span></p>
                <p>email: <span><?php echo $_SESSION['password']; ?></span></p>
                <form method="post" action="../logout.php" class="logout">
                    <button name="logout" class="logout-btn">LOG OUT</button>
                </form>
            </div>
        </section>
                 
        <section class = "order-container">
            <h1 class = "title">Total placed orders</h1>
            <div class = "box-container">
                <?php
                    $sql1 = "SELECT * FROM orders;";
                    $select_orders = pg_query($con, $sql1) or die('query failed');
                    if(pg_num_rows($select_orders) > 0)
                    {
                        while($fetch_orders = pg_fetch_assoc($select_orders))
                        {
                ?>
                <div class = "box">
                    <p>User ID: <span><?php echo $fetch_orders['user_id']; ?></span></p>
                    <p>User Name: <span><?php echo $fetch_orders['name']; ?></span></p> 
                    <p>Email: <span><?php echo $fetch_orders['email']; ?></span></label> </p>
                    <p>Number: <span><?php echo $fetch_orders['number']; ?></span></label> </p>
                    <p>Address: <span><?php echo $fetch_orders['address']; ?></span></label> </p>
                    <p>Placed On: <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
                    <p>Method: <span><?php echo $fetch_orders['method']; ?></span></label> </p>
                    <p>Total Products: <span><?php echo $fetch_orders['total_products']; ?></span></p>
                    <p>Total Price: $<span><?php echo $fetch_orders['total_price']; ?></span></label> </p>
                    <form methos = "post">
                        <input type="hidden" name="order_id" value = "<?php $fetch_orders['id'] ?>">
                        <select name = "update_payment">
                            <option disabled selected><?php echo $fetch_orders['payment_status']; ?></option>
                            <option value = "pending">Pending</option>
                            <option value = "completed">completed</option>
                        </select>
                        <input type = "submit" name = "update_order" value = "update order" class = "btn">
                        <a href = "orders.php?delete=<?php echo $fetch_orders['id']; ?>" class = "delete" onclick="return confirm('delete this')">Delete</a>
                    </form>
                </div>
                <?php 
                        }
                    }
                ?>
            </div>
        </section>

        <footer id= "foo" class="section-p1">
            <div class="col">
                <img src="image/logo.png" alt="">
                <h4>Contact</h4>
                <p><strong>Address: </strong>Suez, El-Salam</p>
                <p><strong>Phone: </strong> +201143320506</p>
                <div class="follow">
                    <h4>Follow us</h4>
                    <div class="icons">
                    <a href="http://facebook.com"><i class="fa-brands fa-facebook"></i></a>
                    <i class="fa-brands fa-twitter"></i>
                    <i class="fa-brands fa-instagram"></i>
                    </div>
                </div>
            </div>
            <div class="col">
                <h4>About</h4>
                <a href="#">Privacy Policy</a>
                <a href="#">Terms & conditions</a>
                <a href="#">Contact Us</a>
            </div>
            <div class="col">
                <h4>My Account</h4>
                <a href="#">Sign In</a>
                <a href="#">View Cart</a>
                <a href="#">My Wishlist</a>
                <a href="#">Help</a>
            </div>
            <div class="col install">
                <h4>install App</h4>
                <p>Form App Store or Google Play</p>
                <div class="row">
                    <a href="http://facebook.com"><img src="image/app.jpg" alt=""></a>
                    <img src="image/play.jpg" alt="">
                </div>
                <p>Secured Payment Gateways </p>
                <img src="image/pay.png" alt="">
            </div>
            <div class="copyright">
                <p>© 2023, WhiteHaTech - Computer Store</p>
            </div>
        </footer >
        <script src="script.js"></script>
    </body>
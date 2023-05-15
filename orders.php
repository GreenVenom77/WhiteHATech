<?php 
    include "conn.php";

    $user_id = $_SESSION['user_id'];

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
        <link rel="stylesheet" href="Assets/font/css/all.css">
        <link rel="stylesheet" href="Assets/css/style.css">
        <link rel="stylesheet" href="Assets/css/orders.css">
        <title>WhiteHaTech Store</title>
    </head>

    <body>
        
        <section id="header">
            <a href="#"><img src="Assets/imgs/logow2.png" class="logo" alt=""></a>

            <div>
                <ul id="navbar">
                    <li><a href="index.html">Home</a></li>
                    <li><a href="Product.html">Product</a></li>
                    <li><a href="About.html">About</a></li>
                    <li><a href="Contact.html">Contact</a></li>
                    <li><a href="cart.html"><i class="fa-solid fa-cart-shopping"></i></i></a></li>
                    <li><i class="fa-solid fa-user" id="user-btn"></i></li>
                </ul>
            </div>
            <div class="user-box">
                <?php if(isset($_SESSION['email']) && isset($_SESSION['user_name'])){ ?>
                    <p>Username: <span><?Php echo $_SESSION['user_name']; ?></span></p>
                    <p>Email: <span><?php echo $_SESSION['email']; ?></span></p>
                    <button name="orders" class="orders-btn" onclick="window.location.href='orders.php'">Orders</button>
                    <button name="logout" class="logout-btn" onclick="window.location.href='logout.php'">Logout</button>
                <?php }
                    else{ ?>
                        <button name="login" class="login-btn" onclick="window.location.href='login.php'">Login</button>
                        <button name="register" class="register-btn" onclick="window.location.href='register1.php'">Register</button>
                <?php } ?>
            </div>
        </section>
                 
        <section class = "order-container">
            <h1 class = "title">Total placed orders</h1>
            <div class = "box-container">
                <?php
                    $sql1 = "SELECT * FROM orders WHERE user_id = '$user_id'";
                    $select_orders = pg_query($con, $sql1) or die('query failed');
                    if(pg_num_rows($select_orders) > 0)
                    {
                        while($fetch_orders = pg_fetch_assoc($select_orders))
                        {
                ?>
                <div class = "box">
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
                        <a href = "orders.php?delete=<?php echo $fetch_orders['id']; ?>" class = "delete" onclick="return confirm('Delete the order?')">Delete</a>
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
                <img src="Assets/imgs/logo2.png" alt="">
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
                <a href="#">View Cart</a>
                <a href="#">My Wishlist</a>
                <a href="#">Help</a>
            </div>
            <div class="copyright">
                <p>© 2023, WhiteHaTech - Computer Store</p>
            </div>
        </footer >
        <script src="Assets/js/script.js"></script>
    </body>
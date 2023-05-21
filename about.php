<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="x-UA-compatible" content="IE-edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="Assets/css/all.css">
        <link rel="stylesheet" href="Assets/css/w&c.css">
        <link rel="stylesheet" href="Assets/css/a&c.css">
        <title>WhiteHaTech Store</title>
        <link rel="icon" type="image/x-icon" href="Assets/imgs/logo2.ico">

    </head>

    <body>
        <nav id="header">
            <a href="#"><img src="Assets/imgs/logow2.png" class="logo" alt=""></a>

            <div>
                <ul id="navbar">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="shop.php">Products</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a class="active" href="about.php">About</a></li>
                    <li><form method="post" action="certain_user.php"><input type="text" placeholder="Search..." name="search">
                    <button type="submit" name="submit"><i class="fa-solid fa-magnifying-glass"></i></button></form></li>
                </ul>
            </div>
            <div class="icons">
            <i class="fa-solid fa-user" id="user-btn"></i>
            <?php 
                if(isset($user_id)){
                    $s_w=pg_query($con,"SELECT * FROM wishlist where u_id = '$user_id';") or die ('query failed');
                    $w_n_r=pg_num_rows($s_w);
                }
            ?>
            <a href="wishlist.php"><i class="fa-solid fa-heart"></i><span>(<?php echo $w_n_r;?>)</span></a>
            <?php 
                if(isset($user_id)){
                    $s_c=pg_query($con,"SELECT * FROM invoice_details where u_id= '$user_id' AND invoice_num=last_invoice();") or die ('query failed');
                    $c_n_r=pg_num_rows($s_c);
                }
            ?>
    
            <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i><span>(<?php echo $c_n_r;?>)</span></a>
            </div>
            <div class="user-box">
                <?php 
                    if(isset($_SESSION['email']) && isset($_SESSION['user_name']))
                    {
                ?>
                        <p>Username: <span><?Php echo $_SESSION['user_name']; ?></span></p>
                        <p>Email: <span><?php echo $_SESSION['email']; ?></span></p>
                        <button name="orders" class="orders-btn" onclick="window.location.href='orders.php'">Orders</button>
                        <button name="logout" class="logout-btn" onclick="window.location.href='logout.php'">Logout</button>
                <?php
                    }
                    else
                    {
                ?>
                        <button name="login" class="login-btn" onclick="window.location.href='login.php'">Login</button>
                        <button name="register" class="register-btn" onclick="window.location.href='register1.php'">Register</button>
                <?php
                    }
                ?>
            </div>
        </nav>

        <section id="about_us" class="section-p1">
            <img src="1.jpeg" alt="">
            <div>
                <h2>How We Are?</h2>   
                <h6>We are a students in faculty of computers and information - suez university <br>  
                    This is Our First Project This project about seals the books </h6>
                <br><br>
                <marquee bgcolor="#ccc" loop="-1" scro11amount="5" width="100%">
                    <h3>Welcome to our site</h3>
                </marquee>

             </div>
        </section>
        <section id="about-app" class="section-p1">
            <h1>Download Our <a href="#">app</a></h1>
            <div class="video">
                <video autoplay muted loop src="2.mp4"></video>
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
<?php

    include "conn.php";

    session_start();

    echo "<div style='background-color:blue;color:white;'></div>";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="x-UA-compatible" content="IE-edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="Assets/font/css/all.css">
        <link rel="stylesheet" href="Assets/css/style.css">
        <link rel="stylesheet" href="Assets/css/home.css">
        <title>WhiteHaTech Store</title>
    </head>

    <body>
        <section id="header">
            <a href="#"><img src="Assets/imgs/logow2.png" class="logo" alt=""></a>

            <div>
                <ul id="navbar">
                    <li><a class="active" href="index.html">Home</a></li>
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

        <section id="home">
            <div class="slider">
                <div class="slide-show-container">
                    <div class = "wrapper1">
                        <div class = "wrapper-text">
                            inspired by goods
                        </div>
                    </div>
                    <div class="wrapper2">
                        <div class = "wrapper-text">
                            inspired by power
                        </div>
                    </div>
                    <div class="wrapper3">
                        <div class = "wrapper-text">
                            inspired by home
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class = "card">
                    <div class = "details">
                        <span>GCards</span>
                        <h1>GTX 1050ti</h1>
                        <a href="#">Cart</a>
                    </div>
                </div>
                <div class = "card">
                    <div class = "details">
                        <span>GCards</span>
                        <h1>GTX 1050</h1>
                        <a href="#">Cart</a>
                    </div>
                </div>
                <div class = "card">
                    <div class = "details">
                        <span>GCards</span>
                        <h1>GT 1030</h1>
                        <a href="#">Cart</a>
                    </div>
                </div>
                <div class = "card">
                    <div class = "details">
                        <span>GCards</span>
                        <h1>GT 1030</h1>
                        <a href="#">Cart</a>
                    </div>
                </div>
            </div>

            <div class="categories">
                <h1 class="title">Categories</h1>
                <div class="box-container">
                    <div class = "box">
                        <img src="Assets/imgs/">
                        <span>Category1</span>
                    </div>
                    <div class = "box">
                        <img src="Assets/imgs/">
                        <span>Category2</span>
                    </div>
                    <div class = "box">
                        <img src="Assets/imgs/">
                        <span>Category3</span>
                    </div>
                </div>
            </div>

            <div class="banner3">
                <div class="detail">
                    <span>All pc parts</span>
                    <h1>Components</h1>
                    <p>Order and we deliver</p>
                    <a href ="user_products.php">Explore<i class="bi bi-arrow-right"></i></a>
                </div>
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
                <img src="Assets/imgs/pay.png" alt="">
            </div>
            <div class="copyright">
                <p>© 2023, WhiteHaTech - Computer Store</p>
            </div>
        </footer >
        <script src="Assets/js/script.js"></script>
    </body>
</html>

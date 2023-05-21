<?php

    include "conn.php";

    $user_id = $_SESSION['user_id'];

    $message = $_POST['message'];

    /*_--------adding product to wishlist-----------_*/
    if(isset($_POST['add_to_wishlist'])){
        $product_id=$_POST['product_id'];
        $product_name=$_POST['product_name'];
        $product_price=$_POST['product_price'];
        $product_image=$_POST['product_image'];

        $wishlist_number=pg_query($con,"SELECT * FROM wishlist where pid='$product_id' and u_id='$user_id';") or die ('query failed');
        $cart_number=pg_query($con,"SELECT * FROM invoice_details where invoice_num =last_invoice() AND u_id= '$user_id';") or die ('query failed');
        if(pg_num_rows($wishlist_number)>0){
            echo "product already exist in wishlist";
        }else if(pg_num_rows($cart_number)>0){
            echo "product already exist in cart";
        }else{
        pg_query($con,"INSERT INTO wishlist(u_id, pid)	VALUES ( '$user_id', '$product_id');");
        echo "product successfuly added to wishlist";
        }
    }
     /*---------------add to cart--------*/
     if(isset($_POST['add_to_cart'])){
        $product_id=$_POST['product_id'];
        $product_name=$_POST['product_name'];
        $product_price=$_POST['product_price'];
        $product_image=$_POST['product_image'];
        $qty=$_POST['qty'];

        $cart_number=pg_query($con,"SELECT * FROM invoice_details where product_id ='$product_id' AND u_id= '$user_id';") or die ('query failed');
         if(pg_num_rows($cart_number)>0){
            echo "product already exist in cart";
    }else{
        pg_query($con,"INSERT INTO invoice_details(invoice_num, product_id, qty, unit_price,  u_id)
        VALUES (last_invoice(), '$product_id','$qty', $product_price, '$user_id');");
        echo "product successfuly added to cart";
    }
    }

    if(isset($_POST['message']) && isset($_SESSION['user_id']))
    {
        $res = pg_query($con,"UPDATE users SET  message= '$message' WHERE u_id='$user_id';") or  die('queury failed');
        if($res)
        {
            echo 
                "
                    <script>
                        alert('The message has been sent');
                        document.location.href = 'contact.php';
                    </script>
                ";
        }
    }

    echo "<div style='background-color:blue;color:white;'></div>";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="x-UA-compatible" content="IE-edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="Assets/font/css/all.css">
        <link rel="stylesheet" href="Assets/css/w&c.css">
        <link rel="stylesheet" href="Assets/css/a&c.css">
        <title>WhiteHATech Store</title>
        <link rel="icon" type="image/x-icon" href="Assets/imgs/logo2.ico">
    </head>

    <body>
        <nav id="header">
            <a href="#"><img src="Assets/imgs/logow2.png" class="logo" alt=""></a>

            <div>
                <ul id="navbar">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="shop.php">Products</a></li>
                    <li><a class="active" href="contact.php">Contact</a></li>
                    <li><a href="about.php">About</a></li>
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

        <section id="contact-details" class="section-p1">
            <div class="details">
                <h1>Get In Touch</h1>
                <h2>Contact us today</h2>
                <div>
                    <li>
                        <i class="far fa-envelope"></i>
                        <p>whitehatech@gmail.com</p>
                    </li>
                    <li>
                        <i class="far fa-clock"></i>
                        <p>Sunday to Thursday: 9am to 3pm</p>
                    </li>
                </div>
            </div>
            <img src="dev_images/c.jpg" alt="">
        </section>
        <section id="form-details">
            <?php 
                if(isset($_SESSION['email']) && isset($_SESSION['user_name']))
                {
            ?>
                    <form method="post">
                        <h1>SEND A MESSAGE</h1>
                        <h2>We Love To Hear From You</h2>
                        <textarea name="message" cols="30" rows="18" placeholder="Your Massage"></textarea>
                        <input class="normal" type="submit" name="submit_done">
                    </form>
            <?php
                }
                else
                {
            ?>
                    <h1>Please signin or register to send us a message</h1>
            <?php
                }
            ?>
                <div class="people">
                    <div>
                        <img src="dev_images/m.jpg" alt>
                        <p>
                            <span>Mohammed Abdelmaksoud</span>
                            <span>Student at FCI- Suez University</span>
                            <span>Phone: +201027676158</span>
                            <span>E-mail: mohammed010987ahmed@gmail.com</span>
                        </p>
                    </div>
                    <div>
                        <img src="dev_images/kh.jpeg" alt>
                        <p>
                            <span>Khaled Mohamed Said</span>
                            <span>Student at FCI- Suez University</span>
                            <span>Phone: +201143320506</span>
                            <span>E-mail: khaled2002khsh@gmail.com</span>
                        </p>
                    </div>
                <div>
                    <img src="dev_images/ho.jpeg" alt>
                    <p>
                        <span>Hossam Walid</span>
                        <span>Student at FCI- Suez University</span>
                        <span>Phone: +201144161234</span>
                        <span>E-mail: hosome2727@gmail.com</span>
                    </p>
                </div>
                <div>
                    <img src="dev_images/ka.jpeg" alt>
                    <p>
                        <span>Kareem Ahmed</span>
                        <span>Student at FCI- Suez University</span>
                        <span>Phone: +201289007399</span>
                        <span>E-mail: ahmedoooo701@gimal.com</span>
                    </p>
                </div>
                <div>
                    <img src="dev_images/ke.jpeg" alt>
                    <p>
                        <span>Kareem Essam</span>
                        <span>Student at FCI- Suez University</span>
                        <span>Phone: +201201191686</span>
                        <span>E-mail: kareemessam878@gmail.com</span>
                    </p>
                </div>
                <div>
                    <img src="dev_images/ha.jpeg" alt>
                    <p>
                        <span>Hatem Mehana</span>
                        <span>Student at FCI- Suez University</span>
                        <span>Phone: +201016867349</span>
                        <span>E-mail: Hatemmehana666@gmail.com</span>
                    </p>
                </div>
                <div>
                    <img src="dev_images/at.jpeg" alt>
                    <p>
                        <span>Ahmed Atef</span>
                        <span>Student at FCI- Suez University</span>
                        <span>Phone: +201017640634</span>
                        <span>E-mail: ahmedzamzam600@gmail.com</span>
                    </p>
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
                <a href="contact.php">Contact Us</a>
            </div>
            <div class="col">
                <h4>My Account</h4>
                <a href="cart.php">View Cart</a>
                <a href="wishlist.php">My Wishlist</a>
                <a href="contact.php">Help</a>
            </div>
            <div class="copyright">
                <p>© 2023, WhiteHATech - Computer Store</p>
            </div>
        </footer >
        <script src="Assets/js/script.js"></script>
    </body>
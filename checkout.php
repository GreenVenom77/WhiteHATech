<?php

    include "conn.php";
    $user_id = $_SESSION['u_id'];
    if(!isset($user_id)){
        header('location:login.php');
    }

    /*----------------------order placed--------------*/
    if(isset($_POST['order_btn'])){
        $name=pg_escape_string($con,$_POST['name']);
        $email=pg_escape_string($con,$_POST['email']);
        $number=pg_escape_string($con,$_POST['number']);
        $method=pg_escape_string($con,$_POST['method']);
        $address=pg_escape_string($con,'flat no. '.$_POST['flate'].','.$_POST['street'].','.$_POST['city']) ;
        pg_query($con,"INSERT INTO invoice( net_total, user_name, email, method, address, number)
        VALUES ( 12, '$name', '$email', '$method', 'address', '$number');")  or die('failed');
        pg_query($con,"insert into invoice_details (invoice_num) values(last_invoice()+1)");
    }
    echo "<div style='background-color:blue;color:white;'></div>";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="x-UA-compatible" content="IE-edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../font/css/all.css">
        <link rel="stylesheet" href="w&c.css">
        <link rel="stylesheet" href="home.css">
        <title>WhiteHaTech Store</title>
    </head>

    <body>
        <nav id="header">
            <a href="#"><img src="image/logow2.png" class="logo" alt=""></a>

            <div>
                <ul id="navbar">
                    <li><a class="active" href="index.php">Home</a></li>
                    <li><a href="Product.html">Product</a></li>
                    <li><a href="About.html">About</a></li>
                    <li><a href="Contact.html">Contact</a></li>
                </ul>
            </div>
            <div class="icons">
            <i class="fa-solid fa-user" id="user-btn"></i>
            <?php 
            
            $s_w=pg_query($con,"SELECT * FROM wishlist where u_id = '$user_id';") or die ('query failed');
            $w_n_r=pg_num_rows($s_w);
            ?>
            <a href="wishlist.php"><i class="fa-solid fa-heart"></i><span>(<?php echo $w_n_r;?>)</span></a>
            <?php 
            
            $s_c=pg_query($con,"SELECT * FROM invoice_details where invoice_num=last_invoice() AND u_id= '$user_id' ;") or die ('query failed');
            $c_n_r=pg_num_rows($s_c);
            ?>
    
    <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i><span>(<?php echo $c_n_r;?>)</span></a>
            </div>
            <div class="user-box">
                <?php if(isset($_SESSION['password']) && isset($_SESSION['user_name'])){ ?>
                    <p>Username: <span><?Php echo $_SESSION['user_name']; ?></span></p>
                    <p>Email: <span><?php echo $_SESSION['email']; ?></span></p>
                    <form method="post" action="logout.php" class="logout">
                        <button name="logout" class="logout-btn">LOG OUT</button>
                    </form>
                <?php }
                    else{ ?>
                        <button name="login" class="login-btn" onclick="window.location.href='login.php'">Login</button>
                        <button name="register" class="register-btn" action="register1.php">Register</button>
                <?php } ?>
            </div>
        </nav>

        <div class="checkout-form">
            <h1 class="title">Payment Process</h1>
            <div class="display-order">
                <?php
                $select_cart=pg_query($con,"SELECT * FROM invoice_details INNER JOIN product ON invoice_details.product_id = product.product_id where u_id='$user_id' and invoice_num = last_invoice()");
                $total=0;
                $grand_total=0;
                if(pg_num_rows($select_cart)>0){
                    while($fetch_cart=pg_fetch_assoc($select_cart)){
                        $total_price=($fetch_cart['sub_total']);
                        $grand_total=$total+=$total_price;
                    ?>
                    <span><?=$fetch_cart['product_name'];?>(<?=$fetch_cart['qty'];?>)</span>
                    <?php
                    }
                };
                ?>
                <span class="grand-total">Total Amount Payable : $<?= $grand_total; ?></span>
            </div>
            <form method="post">
                <div class="input-field">
                <label>Your Name</label>
                <input type="text" name="name" placeholder="Enter Your Name">
                </div>
                <div class="input-field">
                <label>Your Number</label>
                <input type="text" name="number" placeholder="Enter Your Number">
                </div>
                <div class="input-field">
                <label>Your Email</label>
                <input type="text" name="email" placeholder="Enter Your Email">
                </div>
                <div class="input-field">
                <label>Select Payment Method</label>
                <select name="method">
                    <option selected disabled>Select Payment Method</option>
                    <option value="cash on delivery">cash on delivery</option>
                    <option value="credit card">credit card</option>
                    <option value="paypal">paypal</option>
                </select>
                </div>
                <div class="input-field">
                <label>Flate :</label>
                <input type="text" name="flate" placeholder="e.g flate no.">
                </div>
                <div class="input-field">
                <label>Street :</label>
                <input type="text" name="street" placeholder="e.g street">
                </div>
                <div class="input-field">
                <label>city :</label>
                <input type="text" name="city" placeholder="e.g suez">
                </div>
                <input type="submit" name="order_btn" class="btn" value="order now">
            </form>
        </div>

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
        <script src="script.js"></script>
    </body>
</html>

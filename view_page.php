<?php

    include "conn.php";
    $user_id = $_SESSION['user_id'];

    /*_--------adding product to wishlist-----------_*/
    if(isset($_POST['add_to_wishlist'])){
        $product_id=$_POST['product_id'];
        $product_name=$_POST['product_name'];
        $product_price=$_POST['product_price'];
        $product_image=$_POST['product_image'];

        if(isset($user_id))
        {
            $wishlist_number=pg_query($con,"SELECT * FROM wishlist where pid='$product_id' and u_id='$user_id';") or die ('query failed');
            $cart_number=pg_query($con,"SELECT * FROM invoice_details where product_id='$product_id' and u_id= '$user_id' ANd invoice_num =last_invoice();") or die ('query failed');
            if(pg_num_rows($wishlist_number)>0){
                header('location:view_page.php?pid='.$product_id);
            }else if(pg_num_rows($cart_number)>0){
                header('location:view_page.php?pid='.$product_id);
            }else{
                pg_query($con,"INSERT INTO wishlist(u_id, pid)	VALUES ( '$user_id', '$product_id');");
                header('location:view_page.php?pid='.$product_id);
            }
        }
        else
        {
            header('location:login.php');
        }
    }

    /*---------------add to cart--------*/
    if(isset($_POST['add_to_cart'])){
        $product_id=$_POST['product_id'];
        $product_name=$_POST['product_name'];
        $product_price=$_POST['product_price'];
        $product_image=$_POST['product_image'];
        $product_qty=$_POST['product_quantity'];

        if(isset($user_id)){
            $cart_number=pg_query($con,"SELECT * FROM invoice_details where product_id='$product_id' and u_id= '$user_id' AND invoice_num =last_invoice();") or die ('query failed');
            if(pg_num_rows($cart_number)>0){
                header('location:view_page.php?pid='.$product_id);
            }else{
                pg_query($con,"INSERT INTO invoice_details(invoice_num, product_id, qty, unit_price, u_id) VALUES (last_invoice(), '$product_id', $product_qty, $product_price, '$user_id');") or die ('query failed');
                header('location:view_page.php?pid='.$product_id);
            }
        }
        else
        {
            header('location:login.php');
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
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="about.php">About</a></li>
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
                    $s_c=pg_query($con,"SELECT * FROM invoice_details where invoice_num=last_invoice() AND u_id= '$user_id'") or die ('query failed');
                    $c_n_r=pg_num_rows($s_c);
                }
            ?>
    
            <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i><span>(<?php echo $c_n_r;?>)</span></a>
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
        </nav>

        <section class="view">
            <div class="view_page">
                <?php
                if(isset($_GET['pid'])){
                    $pid=$_GET['pid'];
                    $select_product=pg_query($con,"SELECT * FROM product where product_id ='$pid';") or die('query failed');
                    if(pg_num_rows($select_product)>0){
                        while($fetch_product = pg_fetch_assoc($select_product)){
                     

                            ?>
                     <form action="" method="post" class="box">
                <img src="admin/image/<?php echo $fetch_product['image']; ?>"><br>
                <div class="detail">
                <div class="name"><?php echo $fetch_product['product_name']; ?></div>
                <div class="price">$<?php echo $fetch_product['price']; ?></div>
                <input type="hidden" name="product_id" value="<?php echo $fetch_product['product_id']; ?>">
                <input type="hidden" name="product_name" value="<?php echo $fetch_product['product_name']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                <div class="icon">
                    <input type="number" name="product_quantity" value="1" min="0" class="quantity"><br>
                    <button type="submit" name="add_to_wishlist" class="bi bi-wishlist"><i class="fa-solid fa-heart"></i></button>
                    <button type="submit" name="add_to_cart" class="bi bi-cart"><i class="fa-solid fa-cart-shopping"></i></button>
                </div>
                <br><div class="description"><?php echo $fetch_product['description']; ?></div>
                </form>
                   <?php
                        }
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
                    <a href="https://twitter.com"><i class="fa-brands fa-twitter"></i></a>
                    <a href="https://www.instagram.com"><i class="fa-brands fa-instagram"></i></a>
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
</html>

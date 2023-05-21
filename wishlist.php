<?php

    include "conn.php";
    $user_id = $_SESSION['user_id'];
    if(!isset($user_id)){
        header('location:login.php');
    }

    /*---------------add to cart--------*/
    if(isset($_POST['add_to_cart'])){
        $product_id=$_POST['product_id'];
        $product_name=$_POST['product_name'];
        $product_price=$_POST['product_price'];
        $product_image=$_POST['product_image'];
        $qty=1;
        $cart_number=pg_query($con,"SELECT * FROM invoice_details where product_id='$product_id' and u_id= '$user_id' ANd invoice_num =last_invoice();") or die ('query failed');
         if(pg_num_rows($cart_number)>0){
            header('location:wishlist.php');
    }else{
        pg_query($con,"INSERT INTO invoice_details(invoice_num, product_id, qty, unit_price,  u_id)
        VALUES (last_invoice(), '$product_id','$qty', $product_price, '$user_id');");
        header('location:wishlist.php');
    }
    }
    /*---------delete product from wishlist-----*/
    if(isset($_GET['delete'])){
        $delete_p=$_GET['delete'];
        pg_query($con,"delete FROM wishlist where id='$delete_p';") or die ('query failed');
        header('location:wishlist.php');
    }
     /*---------delete products from wishlist-----*/
     if(isset($_GET['delete_all'])){
        $delete_p=$_GET['delete_all'];
        pg_query($con,"delete FROM wishlist where u_id='$user_id';") or die ('query failed');
        header('location:wishlist.php');
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
            
            $s_w=pg_query($con,"SELECT * FROM wishlist where u_id = '$user_id';") or die ('query failed');
            $w_n_r=pg_num_rows($s_w);
            ?>
            <a href="wishlist.php"><i class="fa-solid fa-heart"></i><span>(<?php echo $w_n_r;?>)</span></a>
            <?php 
            
            $s_c=pg_query($con,"SELECT * FROM invoice_details where invoice_num=last_invoice() AND u_id= '$user_id'") or die ('query failed');
            $c_n_r=pg_num_rows($s_c);
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
        
        <section class="show-products">
        <div class="wish">
            <h1 class="title">product added in wishlist</h1>
            <div class="box-container">
                <?php
                $grand_total=0;
                $select_wishlist = pg_query($con,"SELECT * FROM wishlist INNER JOIN product ON wishlist.pid = product.product_id where u_id='$user_id'") or die('query failed');
                if(pg_num_rows($select_wishlist) > 0){
                    while($fetch_wishlist = pg_fetch_assoc($select_wishlist)){

                    ?>
                     <form action="" method="post" class="box">
                        <div class="icon">
                            <a href="wishlist.php?delete=<?php echo $fetch_wishlist['id']; ?>" class="bi bi-eye-x"><i class="fa-solid fa-eye-slash"></i></a>
                            <a href="view_page.php?pid=<?php echo $fetch_products['product_id']; ?>" class="bi bi-eye-fill"><i class="fa-solid fa-eye"></i></a>
                        </div>
                <img src="admin/image/<?php echo $fetch_wishlist['image']; ?>"><br>
                <div class="price">$<?php echo $fetch_wishlist['price']; ?></div>
                <div class="name"><?php echo $fetch_wishlist['product_name']; ?></div>
                <input type="hidden" name="product_id" value="<?php echo $fetch_wishlist['product_id']; ?>">
                <input type="hidden" name="product_name" value="<?php echo $fetch_wishlist['product_name']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $fetch_wishlist['price']; ?>">
                <input type="hidden" name="product_image" value="<?php echo $fetch_wishlist['image']; ?>">
                <div class="icons">
                    <button type="submit" name="add_to_cart" class="btn2">add to cart<i class="fa-solid fa-cart-shopping"></i></button>
                </div>
            </form>
                    <?php 
                    $grand_total+= $fetch_wishlist['price'];
                    }
                }else{
                    echo '<img src = "Assets/imgs/empty.webp"<div style="
                    width:100%;
                    margin left:-7px;
                    position:relative"';
                }
                ?>
            </div>
            <div class="wishlist_total">
                <h1>total amount payable : <span>$<?php echo $grand_total ?></span></h1><br><br>
                <a href="shop.php" class="btn2">continue shopping</a>
                <a href="wishlist.php?delete_all" class="btn2 <?php echo ($grand_total>1)?'':'disabled'?>" onclick="return confirm('do you want to delete all from wishlist')">delete all</a>
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
                    <a href="https://www.instagram.com"><i class="fa-brands fa-twitter"></i></a>
                    <a href="https://twitter.com"><i class="fa-brands fa-instagram"></i></a>
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

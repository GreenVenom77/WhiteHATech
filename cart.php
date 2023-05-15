<?php

    include "conn.php";
    $user_id = $_SESSION['user_id'];
    if(!isset($user_id)){
        header('location:login.php');
    }

    /*---------------add to cart--------*/
    /*---------delete product from wishlist-----*/
    if(isset($_GET['delete'])){
        $delete_p=$_GET['delete'];
        pg_query($con,"delete FROM invoice_details where id='$delete_p';") or die ('query failed');
        header('location:cart.php');
    }
     /*---------delete products from wishlist-----*/
     if(isset($_GET['delete_all'])){
        $delete_p=$_GET['delete_all'];
        pg_query($con,"delete FROM invoice_details where u_id='$user_id';") or die ('query failed');
        header('location:cart.php');
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
        <title>WhiteHaTech Store</title>
    </head>

    <body>
        <nav id="header">
            <a href="#"><img src="Assets/imgs/logow2.png" class="logo" alt=""></a>

            <div>
                <ul id="navbar">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="shop.php">Products</a></li>
                    <li><a href="About.php">About</a></li>
                    <li><a href="Contact.php">Contact</a></li>
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
            <h1 class="title">product added in cart</h1>
            <div class="box-container">
                <?php
                $grand_total=0;
                $select_cart = pg_query($con,"SELECT * FROM invoice_details INNER JOIN product ON invoice_details.product_id = product.product_id where u_id='$user_id' and invoice_num = last_invoice()") or die('query failed');
                if(pg_num_rows($select_cart) > 0){
                    while($fetch_cart = pg_fetch_assoc($select_cart)){

                    ?>
                     <div class="box">
                        <div class="icon">
                            <a href="cart.php?delete=<?php echo $fetch_cart['invoice_num']; ?>" class="bi bi-eye-x"><i class="fa-solid fa-eye-slash"></i></a>
                            <a href="view_page.php?pid=<?php echo $fetch_cart['product_id']; ?>" class="bi bi-eye-fill"><i class="fa-solid fa-eye"></i></a>
                        </div>
                <img src="admin/image/<?php echo $fetch_cart['image']; ?>"><br>
                <div class="price">$<?php echo $fetch_cart['price']; ?></div>
                <div class="name"><?php echo $fetch_cart['product_name']; ?></div>
                <form method="post">
                <input type="hidden" name="update_quantity_id" value="<?php echo $fetch_cart['invoice_num']; ?>">
                <div class="qty">
                    <input type="number" min="1" name="update_quantity" value="<?php echo $fetch_cart['qty']; ?>">
                    <input type="submit" name="update_quantity_btn" value="update">
                </div>
                </form>
                <div class="total_amt">
                    Total Amount : <span><?php echo $total_amt = ($fetch_cart['price']*$fetch_cart['qty']);?></span>
                </div>
                     </div>
                    <?php 
                    $grand_total+= $total_amt;
                    }
                }else{
                    echo '<img src = "Assets/imgs/empty.webp"<div style="
                    width:100%;
                    margin left:-7px;
                    position:relative">
                    ';
                }
                ?>
            </div>
            <div class="dlt">
                <a href="cart.php?delete_all" class="btn2">Delete all</a>
            </div>
            <div class="wishlist_total">
                <h1>total amount payable : <span>$<?php echo $grand_total ?></span></h1><br><br>
                <a href="shop.php" class="btn2">continue shopping</a>
                <a href="checkout.php" class="btn2 <?php echo ($grand_total>1)?'':'disabled'?>" onclick="return confirm('do you want to delete all from wishlist')">proceed to check out</a>
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
</html>

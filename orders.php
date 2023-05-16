<?php 
    include "conn.php";

    $user_id = $_SESSION['user_id'];

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
    echo "<div style='background-color:blue;color:white;'></div>";

    if(isset($_GET['delete']))
    {
        $delete_id = $_GET['delete'];
        pg_query($con, "DELETE FROM invoice WHERE invoice_date = '$delete_id'") or die('query failed');
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
        <link rel="stylesheet" href="Assets/css/w&c.css">
        <link rel="stylesheet" href="Assets/css/orders.css">
        <title>WhiteHaTech Store</title>
    </head>

    <body>
        
        <nav id="header">
            <a href="#"><img src="Assets/imgs/logow2.png" class="logo" alt=""></a>

            <div>
                <ul id="navbar">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="shop.php">Products</a></li>
                    <li><a href="contact.php">Contact</a></li>
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
                 
        <section class = "order-container">
            <h1 class = "title">Total placed orders</h1>
            <div class = "box-container">
                <?php
                    $sql1 = "SELECT distinct  invoice_date,user_name, total,email,method,address,number,u_id FROM invoice inner JOIN invoice_details ON invoice_details.invoice_num = invoice.invoice_num where u_id='$user_id'";
                    $select_orders = pg_query($con, $sql1) or die('query failed');
                    if(pg_num_rows($select_orders) > 0)
                    {
                        while($fetch_orders = pg_fetch_assoc($select_orders))
                        {
                ?>
                <div class = "box">
                    <p>User Name: <span><?php echo $fetch_orders['user_name']; ?></span></p> 
                    <p>Email: <span><?php echo $fetch_orders['email']; ?></span></p>
                    <p>Number: <span><?php echo $fetch_orders['number']; ?></span></p>
                    <p>Address: <span><?php echo $fetch_orders['address']; ?></span></p>
                    <p>Placed On: <span><?php echo $fetch_orders['invoice_date']; ?></span></p>
                    <p>Method: <span><?php echo $fetch_orders['method']; ?></span></p>
                    <p>Total Price: $<span><?php echo $fetch_orders['total']; ?></span></p>
                    <form methos = "post">
                        <input type="hidden" name="order_id" value = "<?php $fetch_orders['invoice_date'] ?>">
                        <a href = "orders.php?delete=<?php echo $fetch_orders['invoice_date']; ?>" class = "delete" onclick="return confirm('Delete the order?')">Delete</a>
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
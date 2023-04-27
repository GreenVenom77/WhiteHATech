<?php 
    include "conn.php";

    if(isset($_GET['delete']))
    {
        $delete_id = $_GET['delete'];
        pg_query($con, "DELETE FROM orders WHERE id = '$delete_id'") or die('query failed');
        header('location: "orders.php"');
    }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="x-UA-compatible" content="IE-edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="Assets/css/all.css">
        <link rel="stylesheet" href="Assets/css/style.css">
        <link rel="stylesheet" href="Assets/css/orders.css">
        <title>WhiteHaTech Store</title>
    </head>

    <body>
        <section id="header">
            <a href="#"><img src="Assets/css/imgs/logo-khaled.png" class="logo" alt=""></a>

            <div>
                <ul id="navbar">
                    <li><a class="active" href="index.html">Home</a></li>
                    <li><a href="Product.html">Product</a></li>
                    <li><a href="About.html">About</a></li>
                    <li><a href="Contact.html">Contact</a></li>
                    <li><a href="cart.html"><i class="fa-solid fa-cart-shopping"></i></i></a></li>
                </ul>
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
                    <p>Email: <span><?php echo $fetch_orders['email']; ?></span></p>
                    <p>Number: <span><?php echo $fetch_orders['number']; ?></span></p>
                    <p>Address: <span><?php echo $fetch_orders['address']; ?></span></p>
                    <p>Placed On: <span><?php echo $fetch_orders['placed_on']; ?></span></p>
                    <p>Method: <span><?php echo $fetch_orders['method']; ?></span></p>
                    <p>Total Products: <span><?php echo $fetch_orders['total_products']; ?></span></p>
                    <p>Total Price: $<span><?php echo $fetch_orders['total_price']; ?></span></p>
                    <form methos = "post">
                        <input type="hidden" name="order_id" value = "<?php $fetch_orders['id'] ?>">
                        <select name = "update_payment">
                            <option disabled selected><?php echo $fetch_orders['payment_status']; ?></option>
                            <option value = "pending">Pending</option>
                            <option value = "completed">completed</option>
                        </select>
                        <input type = "submit" name = "update_order" value = "update order" class = "btn">
                        <a href = "orders.php?delete=<?php echo $fetch_orders['id']; ?>" calss = "delete" onclick="return confirm('delete this')">Delete</a>
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
<?php 
    include "../conn.php";

    if(isset($_GET['delete']))
    {
        $delete_id = $_GET['delete'];
        pg_query($con, "DELETE FROM invoice WHERE invoice_num = '$delete_id'") or die('query failed');
        header('location:orders.php');
    }

    if(isset($_POST['update_order'])){
        $update_o_s = $_POST['update_payment'];
        $update_o_id = $_POST['order_id'];
        pg_query($con, "UPDATE invoice SET payment_status='$update_o_s' WHERE invoice_num='$update_o_id';") or die('query failed');
        echo $update_o_id;
        echo $update_o_s;
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="x-UA-compatible" content="IE-edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="font/css/all.css">
        <link rel="stylesheet" href="style.css">
        <title>WhiteHATech Store</title>
        <link rel="icon" type="image/x-icon" href="image/logo2.ico">
    </head>

    <body>
        
    <section id="header">
            <a href="#"><img src="image/logow2.png" class="logo" alt=""></a>
            <div>
                <ul id="navbar">
                    <li><a href="adminHome.php">Home</a></li>
                    <li><a href="admin_products.php">Products</a></li>
                    <li><a  href="admin_users.php">Users</a></li>
                    <li><a class="active" href="orders.php">Orders</a></li>
                    <li><a href="adminMessages.php">Messages</a></li>
                    <li><i class="fa-solid fa-list" id="menu-btn"></i></li>
                    <li><i class="fa-solid fa-user" id="user-btn"></i></li>
                    <li><form method="post" action="certain.php"><input type="text" placeholder="Search..." name="search">
                    <button type="submit" name="submit"><i class="fa-solid fa-magnifying-glass"></i></button></form></li>
                </form></li>
                </ul>
            </div>
            <div class="user-box">
                <p>Username: <span><?Php echo $_SESSION['user_name']; ?></span></p>
                <form method="post" action="../logout.php" class="logout">
                    <button name="logout" class="logout-btn">LOG OUT</button>
                </form>
            </div>
        </section>
                 
        <section class = "order-container">
            <h1 class = "title">Total placed orders</h1>
            <div class = "box-container">
                <?php
                    $sql1 = "select * from invoice ;";
                    $select_orders = pg_query($con, $sql1) or die('query failed');
                    $p_n_=pg_num_rows($select_orders);
                    if(pg_num_rows($select_orders) > 0)
                    {
                        while($fetch_orders = pg_fetch_assoc($select_orders))
                        {
                            $mn=$fetch_orders['invoice_num'];
                            $select_order=pg_query($con,"SELECT invoice_num,u_id FROM invoice_details where invoice_num ='$mn' and u_id is not null ");
                            $p_n=pg_num_rows($select_order);
                            $fet=pg_fetch_assoc($select_order);
                            $select_pd=pg_query($con,"SELECT * FROM invoice_details inner join product on invoice_details.product_id=product.product_id where invoice_num ='$mn' and u_id is not null ;");
                            $fett=pg_fetch_assoc($select_pd);
                ?>
                <div class = "box">
                    <p>User ID: <span><?php echo $fet['u_id']; ?></span></p>
                    <p>User Name: <span><?php echo $fetch_orders['user_name']; ?></span></p> 
                    <p>Email: <span><?php echo $fetch_orders['email']; ?></span></label> </p>
                    <p>Number: <span><?php echo $fetch_orders['number']; ?></span></label> </p>
                    <p>Address: <span><?php echo $fetch_orders['address']; ?></span></label> </p>
                    <p>Placed On: <span><?php echo $fetch_orders['invoice_date']; ?></span> </p>
                    <p>Method: <span><?php echo $fetch_orders['method']; ?></span></label> </p>
                    <p>Total Products: <span><?php echo $p_n; ?></span></p>
                    <p>Products Details: <span><?php if(pg_num_rows($select_pd) > 0){
                                while($fetch_pd = pg_fetch_assoc($select_pd)){ echo $fetch_pd['product_name']."<br>"; } } ?> </span></p>
                    <p>Total Price: $<span><?php echo $fetch_orders['total']; ?></span></label> </p>
                    <form method = "post">
                        <input type="hidden" name="order_id" value = "<?php echo $fetch_orders['invoice_num'] ;?>">
                        <select name = "update_payment">
                            <option disabled selected><?php echo $fetch_orders['payment_status']; ?></option>
                            <option value = "pending">Pending</option>
                            <option value = "completed">completed</option>
                        </select>
                        <input type = "submit" name = "update_order" value = "update order" class = "btn">
                        <a href = "orders.php?delete=<?php echo $fetch_orders['invoice_num']; ?>" class = "delete" onclick="return confirm('Delete this?')">Delete</a>
                    </form>
                </div>
                <?php 
                        }
                    }
                ?>
            </div>
        </section>

        <?php include 'footer.php' ?>
        <script src="script.js"></script>
    </body>
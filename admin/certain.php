<?php
include "../conn.php";
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
        
    <nav id="header">
    <a href="#"><img src="image/logow2.png" class="logo" alt=""></a>
            <div>
                <ul id="navbar">
                    <li><a href="adminHome.php">Home</a></li>
                    <li><a href="admin_products.php">Product</a></li>
                    <li><a href="admin_users.php">Users</a></li>
                    <li><a href="orders.php">Orders</a></li>
                    <li><i class="fa-solid fa-list" id="menu-btn"></i></li>
                    <li><i class="fa-solid fa-user" id="user-btn"></i></li>  
                    <form method="post" action="certain.php">
                    <li><input type="text" placeholder="Search..." name="search"></li>
                    <li><button type="submit" name="submit"><i class="fa-solid fa-magnifying-glass"></i></button></li></form>
                </form></li>
            
                </ul>
            </div>
            <div class="user-box">
                <p>Username: <span><?Php echo $_SESSION['user_name']; ?></span></p>
                <form method="post" action="../logout.php" class="logout">
                    <button name="logout" class="logout-btn">LOG OUT</button>
                </form>
            </div>
    </nav>
     <section class="show-products">
     <div class="box-container">
         <?php
         $str=$_POST["search"];
         $select_products = pg_query($con,"SELECT * FROM product where product_name like LOWER('%$str%');") or die('query failed');
         $select_products = pg_query($con,"SELECT * FROM product where product_name like UPPER('%$str%');") or die('query failed');
         if(pg_num_rows($select_products) > 0){
             while($fetch_products = pg_fetch_assoc($select_products)){

             ?>
             <div class="box">
                 <img src="image/<?php echo $fetch_products['image']; ?>">
                 <p>Price : $ <?php echo $fetch_products['price']; ?></p>
                 <h4><?php echo $fetch_products['product_name']; ?></h4>
                 <p class="detail"><?php echo $fetch_products['description']; ?></p>
                 <a href="admin_products.php?edit=<?php echo $fetch_products['product_id'] ?>" class="edit">edit</a>
                 <a href="admin_products.php?delete=<?php echo $fetch_products['product_id'] ?>" class="delete" onclick="return conform('delete this product');">delete</a>
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
</html>
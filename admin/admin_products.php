<?php 
include "../conn.php";
if(isset($_POST['add_product'])){
    $product_name = pg_escape_string($con,$_POST['name']);
    $product_select = pg_escape_string($con,$_POST['category']);
    $product_unit = pg_escape_string($con,$_POST['unit']);
    $product_price = pg_escape_string($con,$_POST['price']);
    $product_brand = pg_escape_string($con,$_POST['brand']);
    $product_type = pg_escape_string($con,$_POST['type']);
    $product_details = pg_escape_string($con,$_POST['detail']);
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name=$_FILES['image']['tmp_name'];
    $image_folder= 'image/'.$image;

    $select_product_name= pg_query($con,"SELECT * FROM product where product_name = '$product_name';")  or die('queury failed');
    if(pg_num_rows($select_product_name)>0){
    }else{
        $insert_product = pg_query($con,"INSERT INTO product( category_id, product_name, unit, price, brand, type, description, image) VALUES ( '$product_select', '$product_name', '$product_unit', '$product_price','$product_brand' , '$product_type', '$product_details', '$image');") or die('queury failed');
        if($insert_product){
            if($image_size>2000000){
            }else{
                move_uploaded_file($image_tmp_name,$image_folder);
            }
        }
    }
}

/*-------------------deleting product--------*/
if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $select_delete_image=pg_query($con,"SELECT image FROM product where product_id='$delete_id';") or  die('queury failed');
    $fetch_delete_image = pg_fetch_assoc($select_delete_image);
    unlink('image/'.$fetch_delete_image['image']);

    pg_query($con,"DELETE FROM product WHERE  product_id ='$delete_id';") or  die('queury failed');
    pg_query($con,"DELETE FROM invoice_details WHERE  product_id ='$delete_id';") or  die('queury failed');
   /* pg_query($con,"DELETE FROM product WHERE  product_id ='$delete_id';") or  die('queury failed'); */
   header("location:admin_products.php");
}

/*------------------update products-------*/
if(isset($_POST['update_product'])){
    $update_p_id = $_POST['update_p_id'];
    $update_p_name=$_POST['update_p_name'];
    $update_category = $_POST['update_category'];
    $update_units = $_POST['update_units'];
    $update_price = $_POST['update_price'];
    $update_brand = $_POST['update_brand'];
    $update_type = $_POST['update_type'];
    $update_detail = $_POST['update_detail'];
    $update_image = $_FILES['update_image']['name'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_img_folder = 'image/'.$update_image;
    $update_query=pg_query($con,"UPDATE product set product_id='$update_p_id', category_id='$update_category', product_name='$update_p_name', unit='$update_units', price='$update_price', brand='$update_brand', type='$update_type', description='$update_detail', image='$update_image' WHERE product_id='$update_p_id';") or die('query failed');
    if($update_query){
        move_uploaded_file($update_image_tmp_name,$update_img_folder);
        echo "product updated successfully";
        header('location: admin_products.php');
    }else{
        echo "failed";
    }
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
        <title>WhiteHaTech Store</title>
    </head>

    <body>
        
    <section id="header">
            <a href="#"><img src="image/logow2.png" class="logo" alt=""></a>
            <div>
                <ul id="navbar">
                    <li><a href="adminHome.php">Home</a></li>
                    <li><a class="active" href="admin_products.php">Products</a></li>
                    <li><a href="admin_users.php">Users</a></li>
                    <li><a href="orders.php">Orders</a></li>
                    <li><a href="adminMessages.php">Messages</a></li>
                    <li><i class="fa-solid fa-list" id="menu-btn"></i></li>
                    <li><i class="fa-solid fa-user" id="user-btn"></i></li>
                    <li><form method="post" action="certain.php"><input type="text" placeholder="Search..." name="search">
                    <button type="submit" name="submit"><i class="fa-solid fa-magnifying-glass"></i></button></form></li>
                </form></li>
                </ul>
            </div>
            <div class="user-box">
                <p>username: <span><?Php echo $_SESSION['user_name']; ?></span></p>
                <p>email: <span><?php echo $_SESSION['password']; ?></span></p>
                <form method="post" action="../logout.php" class="logout">
                    <button name="logout" class="logout-btn">LOG OUT</button>
                </form>
            </div>
        </section>
        <section class="add-product">
            <form method="post" action="" enctype="multipart/form-data">
                <h1 class="title">Add New Product</h1>
                <div class="input-field">
                    <label>Product Name</label>
                    <input type="text" id= "name" name="name" required>
                </div>
                <div class="input-field">
                    <label>Category</label>
                    <select name="category" id="select">
                        <option value="2">devices</option>
                        <option value="3">accessories</option>
                    </select>
                </div>
                <div class="input-field">
                    <label>Product Units</label>
                    <input type="text" id= "units" name="unit" required>
                </div>
                <div class="input-field">
                    <label>Product Price</label>
                    <input type="text" id= "price" name="price" required>
                </div>
                <div class="input-field">
                    <label>Product Brand</label>
                    <input type="text" id= "brand" name="brand" required>
                </div>
                <div class="input-field">
                    <label>Product Type</label>
                    <input type="text" id= "type" name="type" required>
                </div>
                <div class="input-field">
                    <label>Product Details</label>
                    <textarea name="detail" id= "detail" required></textarea>
                </div>
                <div class="input-field">
                    <label>Product Image</label>
                    <input type="file" name="image" accept="image/jpg , image/png, image/jpeg, image/webp" required>
                </div>
                <input type="submit" name="add_product" value="add product" class="btn" onclick=""my>
            </form>
        </section>
        <!----------show products section ----------->
        <section class="show-products">
            <div class="box-container">
                <?php
                $select_products = pg_query($con,"SELECT * FROM product;") or die('query failed');
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
        <section class="update-container">
            <?php 
            if(isset($_GET['edit'])){
                $edit_id = $_GET['edit'];
                $edit_query= pg_query($con,"SELECT * FROM product where product_id = '$edit_id';")  or die('queury failed');
                if(pg_num_rows($edit_query)>0){
                    while($fetch_edit = pg_fetch_assoc($edit_query)){



                        ?>
                        <form method="post" action="" enctype="multipart/form-data">
                            <img src="image/<?php echo $fetch_edit['image']; ?>">
                            <input type="hidden" name="update_p_id" value="<?php echo $fetch_edit['product_id']; ?>">
                            <div class="input-field">
                           <label>Product Name</label>
                           <input type="text" id= "name" name="update_p_name" value="<?php echo $fetch_edit['product_name']; ?>" required>
                           </div>
                           <div class="input-field">
                    <label>Category</label>
                    <select name="update_category" id="select" value="<?php echo $fetch_edit['category_id']; ?>">
                        <option value="2">devices</option>
                        <option value="3">accessories</option>
                    </select>
                </div>
                <div class="input-field">
                    <label>Product Units</label>
                    <input type="text" id= "units" name="update_units" value="<?php echo $fetch_edit['unit']; ?>" required>
                </div>
                <div class="input-field">
                    <label>Product Price</label>
                    <input type="text" id= "price" name="update_price" value="<?php echo $fetch_edit['price']; ?>" required>
                </div>
                <div class="input-field">
                    <label>Product Brand</label>
                    <input type="text" id= "brand" name="update_brand" value="<?php echo $fetch_edit['brand']; ?>" required>
                </div>
                <div class="input-field">
                    <label>Product Type</label>
                    <input type="text" id= "type" name="update_type" value="<?php echo $fetch_edit['type']; ?>" required>
                </div>
                <div class="input-field">
                    <label>Product Details</label>
                    <textarea name="update_detail" id= "detail" value="<?php echo $fetch_edit['description']; ?>" required></textarea>
                </div>
                <div class="input-field">
                    <label>Product Image</label>
                    <input type="file" name="update_image" accept="image/jpg , image/png, image/jpeg, image/webp" required >
                </div>
                            <input type="submit" name="update_product" value="update" class="edit">
                            <input type="reset" value="cancle" class="option-btn btn" id="close-edit">
                        </form>
                        <?php
                    }
                }
                echo "<script>document.querySelector('.update-container').style.display='block';</script>";
            }
            ?>
        </section>
        <script type ="text/javascript" src="script.js"></script>
    </body>
   <?php include "footer.php" ?> 
</html>
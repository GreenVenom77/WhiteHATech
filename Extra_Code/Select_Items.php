<div class="box-container">
            <?php
                $select_products = pg_query($con,"SELECT * FROM product;") or die('query failed');
                if(pg_num_rows($select_products) > 0){
                    while($fetch_products = pg_fetch_assoc($select_products)){
            ?>
            <form action="" method="post" class="box">
                <img src="admin/image/<?php echo $fetch_products['image']; ?>">
                <div class="price">$<?php echo $fetch_products['price']; ?></div>
                <div class="name"><?php echo $fetch_products['product_name']; ?></div>
                <input type="hidden" name="product_id" value="<?php echo $fetch_products['product_id']; ?>">
                <input type="hidden" name="product_name" value="<?php echo $fetch_products['product_name']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                <div class="icon">
                    <a href="view_page.php?pid=<?php echo $fetch_products['product_id']; ?>" class="bi bi-eye-fill"></a>
                    <button type="submit" name="add_to_cart" class="bi bi-cart"></button>
                </div>
            </form>
            <?php
                    }
                }
            ?>
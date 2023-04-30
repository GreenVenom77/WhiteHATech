<?php

    include "conn.php";

    if(isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['address_1']) && isset($_POST['city']) && isset($_POST['phone_num']))
    {
        function validate($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $first_name = validate($_POST['first_name']);
        $last_name = validate($_POST['last_name']);
        $address_1 = validate($_POST['address_1']);
        $city = validate($_POST['city']);
        $phone_num = validate($_POST['phone_num']);
        

        if(empty($first_name) || empty($last_name) || empty($address_1) || empty($city) || empty($phone_num))
        {
            header("Location: register1.php?error=User Name is required");
            exit();
        }
        else
        {
            $sql1 = "INSERT INTO user_sign ( first_name, last_name, address_1, city, phone_num) VALUES ('$first_name','$last_name','$address_1','$city','$phone_num')";
            $res = pg_query($con,$sql1);
            if($res)
            {
                header("Location: register2.php");
            }
            else
            {
                echo "Error";
            }
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Info</title>
        <link rel="stylesheet" type="text/css" href="Assets/css/lr.css">
    </head>
    <body>
        <form method="post">
            <a href="index.php" class="Logo">
            <img src="Assets/imgs/Logow2.png" alt="Logo">
            </a>
            <h2>Info</h2>
            <label>First Name:</label>
            <input type="text" name="first_name" required> <br>
            <label>Last Name:</label>
            <input type="text" name="last_name"required> <br>
            <label>Address:</label>
            <input type="text" name="address_1" required> <br>
            <label>City:</label>
            <input type="text" name="city" required> <br>
            <label>Phone Number:</label>
            <input type="text" name="phone_num" required> 
            <input class="butn" type="submit" name="submit_done"> <br>
        </form>
    </body>
</html>
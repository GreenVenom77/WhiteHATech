<?php
    include "conn.php";
    if(isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['address_1']) && isset($_POST['city']) && isset($_POST['phone_num']) && isset($_POST['email']))
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
        $email = validate($_POST['email']);

        if(empty($first_name) || empty($last_name) || empty($address_1) || empty($city) || empty($phone_num) || empty($email))
        {
            header("Location: register.html?error=User Name is required");
            exit();
        }
        else
        {
            $sql1 = "INSERT INTO user_sign ( first_name, last_name, address_1, city, phone_num, email) VALUES ('$first_name','$last_name','$address_1','$city','$phone_num','$email')";
            $res = pg_query($con,$sql1);
            
            if($res)
            {
                header("Location: signin.php");
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
        <tittle>Register</tittle>
        <style>

        </style>
    </head>
    <body>
        <form method="post">
            <label>First Name:</label>
            <input type="text" name="first_name"> <br>
            <label>Last Name:</label>
            <input type="text" name="last_name"> <br>
            <label>Address:</label>
            <input type="text" name="address_1"> <br>
            <label>City:</label>
            <input type="text" name="city"> <br>
            <label>Phone Number:</label>
            <input type="text" name="phone_num"> <br>
            <label>Email:</label>
            <input type="text" name="email">
            <input type="submit" name="submit_done"> <br>
        </form>
    </body>
</html>
<?php
include "conn.php";
if(isset($_POST['u_name']) && isset($_POST['user_pass'])){
function validate($data){
    $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
}
$u_name = validate($_POST['u_name']);
$user_pass = validate($_POST['user_pass']);
if(empty($u_name) || empty($user_pass) ){
    
    header("Location: sign.html?error=User Name and user password is required");
    exit();
}
else{
    $sql2 = "INSERT INTO users(
        u_name, user_pass)
        VALUES ('$u_name', '$user_pass');";
    $res = pg_query($con,$sql2);
    if($res){
        echo "Done";
    }
    else{
        echo "Error";
    }
}
}
<?php
session_start();
include "conn.php";
if(isset($_POST['uname']) && isset($_POST['Password'])){
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
$uname = validate($_POST['uname']);
$Pass = validate($_POST['Password']);
if(empty($uname)){
    header("Location: index.php?error=User Name is required");
    exit();
}else if(empty($Pass)){
    header("Location: index.php?error=Password is required");
    exit();
}else {

  $sql=("SELECT * FROM admin where user_name = '$uname' and password='$Pass'") ;
 $result = pg_query($con,$sql);
 if(pg_num_rows($result) === 1){
    $row = pg_fetch_assoc($result);
    if($row['user_name']=== $uname && $row['password']===$Pass){
       $_SESSION['user_name']=$row['user_name'];
       $_SESSION['password']=$row['password'];
       header("Location: home.php");
       exit();
    }
 }
 else{
    header("Location: index.php?error=Incorrect User name or Password");
    exit();
 }

}

}else{
    header("Location: index.php");
    exit();
}
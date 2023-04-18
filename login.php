<?php
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
echo "valid input";
}

}else{
    header("Location: index.php");
    exit();
}
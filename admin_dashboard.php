<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
else{
    if(!$_SESSION["is_admin"]){
        header("location: user_dashboard.php");
}
}
?>
<a href="logout.php">Logout</a>
This is admin dashboard
<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once("dbconnect.php");

$msg = "";

$query = "SELECT * FROM Candidates WHERE election_id = ? AND name = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("ss", $_GET["election_id"], $_SESSION["username"]);
$stmt->execute();
$results = $stmt->get_result();
if($row = $results->fetch_array()){
    $msg = "You are already a candidate for this election";
}
else{
    $msg = "You can candidate for this election";
}
?>
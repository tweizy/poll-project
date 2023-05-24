<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$msg_error = $msg = "";

require_once("dbconnect.php");

$query = "SELECT * FROM Votes WHERE user_id = ? and election_id = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("ss", $_SESSION["user_id"], $_GET["election_id"]);
$stmt->execute();
$results = $stmt->get_result();
if($row = $results->fetch_array()){
    $msg_error = "You have already voted for this election";
    header("location: election_detail.php?election_id=".$_GET["election_id"]."&msg_error=$msg_error");
}
else{
    $query = "INSERT INTO Votes (election_id, user_id, vote, vote_date) VALUES (?, ?, ?, curdate())";
    $stmt = $db->prepare($query);
    $stmt->bind_param("sss", $_GET["election_id"], $_SESSION["user_id"], $_GET["name"]);
    $stmt->execute();
    $msg = "You have successfully voted for ".$_GET["name"]." in this election";
    header("location: election_detail.php?election_id=".$_GET["election_id"]."&msg=$msg");
}
?>
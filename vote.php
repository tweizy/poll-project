<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once("dbconnect.php");

$query = "SELECT * FROM Votes WHERE user_id = ? and election_id = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("ss", $_SESSION["user_id"], $_GET["election_id"]);
$stmt->execute();
$results = $stmt->get_result();
if($row = $results->fetch_array()){
    $msg_error = "You have already voted for ".$row["vote"]." this election";
    header("location: election_detail.php?election_id=".$_GET["election_id"]."&msg_error=$msg_error");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style_user_dashboard.css">
    <style>
        .buttons{
            display: flex;
            flex-direction: row;
            justify-content: end;
            margin-top: 20px;
            margin-right: 20px;
        }

        .buttons > a > button{
            margin-left: 20px;
        }
    </style>
</head>
<body>
    <div class="buttons">
        <a href="logout.php"><button type="button" class="btn btn-danger">Logout</button></a>
        <a href="change-password.php"><button type="button" class="btn btn-success">Change password</button></a>
        <a href="admin_dashboard.php"><button type="button" class="btn btn-primary">Dashboard</button></a>
    </div>

    <div class="ag-format-container">
    <div class="ag-courses_box" style="margin-top: 5%;">
        <?php
        $query = "SELECT * FROM Candidates INNER JOIN Programs on Programs.candidate_id = Candidates.candidate_id WHERE Candidates.election_id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("i", $_GET["election_id"]);
        $stmt->execute();
        $results = $stmt->get_result();
        while($row = $results->fetch_array()){
            echo '<div class="ag-courses_item">
            <a href="validate_vote.php?election_id='.$row["election_id"].'&name='.$row["name"].'" class="ag-courses-item_link">
                <div class="ag-courses-item_bg"></div>
    
                <div class="ag-courses-item_title">
                '.$row["program_title"].'
                </div>
    
                <div class="ag-courses-item_date-box" style="margin-top: -50px">
                Description:
                <span class="ag-courses-item_date">
                    '.$row["program_description"].'
                </span>
                </div>
            </a>
            </div>';
        }
        ?>
    </div>
    </div>
</body>
</html>
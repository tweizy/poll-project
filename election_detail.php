<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once("dbconnect.php");

$query = "SELECT * FROM Elections WHERE election_id = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("s", $_GET["election_id"]);
$stmt->execute();
$results = $stmt->get_result();
$row = $results->fetch_array()
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Election detail</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
    <?php
    if(isset($_GET["msg"])){
        echo '<div class="alert alert-success" role="alert">
        '.$_GET["msg"].'
        </div>';
    }
    if(isset($_GET["msg_error"])){
        echo '<div class="alert alert-danger" role="alert">
        '.$_GET["msg_error"].'
        </div>';
    }
    ?>
    <div class="buttons">
        <a href="logout.php"><button type="button" class="btn btn-danger">Logout</button></a>
        <a href="change-password.php"><button type="button" class="btn btn-success">Change password</button></a>
        <a href="admin_dashboard.php"><button type="button" class="btn btn-primary">Dashboard</button></a>
    </div>
    <div style="display: flex; align-items: center; flex-direction: column; margin-top: 50px">
        <?php
        echo "Title: ". $row["title"]."<br>";
        echo "Description: ". $row["description"]."<br>";
        echo "Start date: ". $row["start_date"]."<br>";
        echo "End date: ". $row["end_date"]."<br>";
        ?>
        <div style="margin-top: 20px">
            <a href="add_candidature.php?election_id=<?php echo $_GET["election_id"] ?>"><button type="button" class="btn btn-danger">Candidate</button></a>
            <a href="vote.php?election_id=<?php echo $_GET["election_id"] ?>"><button type="button" class="btn btn-primary">Vote</button></a>
        </div>
    </div>
</body>
</html>
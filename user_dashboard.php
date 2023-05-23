<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
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
    </div>

    <?php
    ?>

    <div class="ag-format-container">
    <div class="ag-courses_box" style="margin-top: 5%;">
        <?php
        require_once("dbconnect.php");

        $query = "SELECT * FROM Elections WHERE start_date <= NOW() AND end_date > NOW() ORDER BY start_date ASC";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $results = $stmt->get_result();
        while($row = $results->fetch_array()){
            echo '<div class="ag-courses_item">
            <a href="election_detail.php?election_id='.$row["election_id"].'" class="ag-courses-item_link">
                <div class="ag-courses-item_bg"></div>
    
                <div class="ag-courses-item_title">
                '.$row["title"].'
                </div>
    
                <div class="ag-courses-item_date-box">
                Start date:
                <span class="ag-courses-item_date">
                    '.$row["start_date"].'
                </span>
                </div>
                <div class="ag-courses-item_date-box">
                End date:
                <span class="ag-courses-item_date">
                    '.$row["end_date"].'
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
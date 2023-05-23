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


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
        <a href="add_election.php"><button type="button" class="btn btn-light">Add Election</button></a>
    </div>

    <?php
    ?>

    <div class="ag-format-container">
    <div class="ag-courses_box" style="margin-top: 10%;">
        <div class="ag-courses_item">
        <a href="#" class="ag-courses-item_link">
            <div class="ag-courses-item_bg"></div>

            <div class="ag-courses-item_title">
            Election délégué UM6P-CS
            </div>

            <div class="ag-courses-item_date-box">
            Start:
            <span class="ag-courses-item_date">
                04.11.2022
            </span>
            </div>
        </a>
        </div>

        <div class="ag-courses_item">
        <a href="#" class="ag-courses-item_link">
            <div class="ag-courses-item_bg"></div>

            <div class="ag-courses-item_title">
            Election Président BDE UM6P-CS
            </div>

            <div class="ag-courses-item_date-box">
            Start:
            <span class="ag-courses-item_date">
                04.11.2022
            </span>
            </div>
        </a>
        </div>

        <div class="ag-courses_item">
        <a href="#" class="ag-courses-item_link">
            <div class="ag-courses-item_bg"></div>

            <div class="ag-courses-item_title">
            Election Président BDS UM6P-CS
            </div>

            <div class="ag-courses-item_date-box">
            Start:
            <span class="ag-courses-item_date">
                04.11.2022
            </span>
            </div>
        </a>
        </div>
    </div>
    </div>
</body>
</html>
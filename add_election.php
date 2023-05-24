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

require_once("dbconnect.php");

$title = $description = $end_date = "";
$title_error = $description_error = $date_error = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["title"]))){
        $title_error = "Please enter the election's title";
    }
    else{
        $title = trim($_POST["title"]);
    }
    if(empty(trim($_POST["description"]))){
        $description_error = "Please enter the election's description";
    }
    else{
        $description = trim($_POST["description"]);
    }
    if(empty(trim($_POST["date"]))){
        $date_error = "Please enter the election's end date";
    }
    else{
        $end_date = trim($_POST["date"]);
    }

    $title = str_replace("'", "''", $title);
    $description = str_replace("'", "''", $description);

    if(empty($title_error) && empty($description_error) && empty($date_error)){
        $query = "INSERT INTO Elections (title, description, start_date, end_date) VALUES ('$title', '$description', curdate(), '$end_date')";
        $stmt = $db-> prepare($query);
        $stmt->execute();
        header("location: admin_dashboard.php");

    }
}
?>

<!doctype html>
<html lang="en">
  <head>
  	<title>Add Election</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="style.css">
	</head>
	<body>
    <div class="buttons">
        <a href="logout.php"><button type="button" class="btn btn-danger">Logout</button></a>
        <a href="change-password.php"><button type="button" class="btn btn-success">Change password</button></a>
        <a href="admin_dashboard.php"><button type="button" class="btn btn-primary">Dashboard</button></a>
    </div>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h1 class="heading-section">Add Election</h1>
				</div>
			</div>
            <div class="d-flex" style="flex-direction: column; width: 600px; margin: auto">
			      		<div class="w-100">
			      			<h3 class="mb-4">Election details</h3>
			      		</div>
                          <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" class="signin-form">
                            <div class="form-group mb-3">
                                <label class="label" for="title">Title</label>
                                <input type="text" name="title" id="title" class="form-control" placeholder="Title" required>
                            </div>
                            <div class="form-group mb-3">
                                <label class="label" for="description">Description</label>
                                <input type="text" name="description" id="description" class="form-control" placeholder="description" required>
                            </div>
                            <div class="form-group mb-3">
                                <label class="label" for="date">End date</label>
                                <input type="date" name="date" id="date" class="form-control" placeholder="End date" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary submit px-3">Add Election</button>
                            </div>  
                            <?php 
                            if(!empty($title_error)){
                                echo '<div class="alert alert-danger">' . $title_error . '</div>';
                            }
                            elseif(!empty($description_error)){
                                echo '<div class="alert alert-danger">' . $description_error . '</div>';
                            }   
                            elseif(!empty($date_error)){
                                echo '<div class="alert alert-danger">' . $date_error . '</div>';
                            }          
                            ?>
		                </form>
			      	</div>
						
		            </div>
	</section>

	<script src="js/jquery.min.js"></script>
  <script src="js/popper.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>

	</body>
</html>


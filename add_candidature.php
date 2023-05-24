<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once("dbconnect.php");

$msg = $msg_error = "";

$query = "SELECT * FROM Candidates WHERE election_id = ? AND name = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("ss", $_GET["election_id"], $_SESSION["username"]);
$stmt->execute();
$results = $stmt->get_result();
if($row = $results->fetch_array()){
    $msg_error = "You are already a candidate for this election";
    header("location: election_detail.php?election_id=".$_GET["election_id"]."&msg_error=$msg_error");
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
        $msg = "You have candidated for this election succesfuly";
        $query = "INSERT INTO Candidates (election_id, name, photo) VALUES (?, ?, ?)";
        $stmt = $db-> prepare($query);
        $photo = "photo/".$_SESSION["username"];
        $stmt->bind_param("sss", $_POST["election_id"], $_SESSION["username"], $photo);
        $stmt->execute();

        $query = "SELECT * FROM Candidates WHERE election_id = ? AND name = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("ss", $_POST["election_id"], $_SESSION["username"]);
        $stmt->execute();
        $results = $stmt->get_result();
        $row = $results->fetch_array();
        $candidate_id = $row["candidate_id"];

        $program_title = $_POST["title"];
        $program_description = $_POST["description"];
        $video = "video/".$_SESSION["username"]."_".$_POST["election_id"];
        $affiche = "affiche/".$_SESSION["username"]."_".$_POST["election_id"];

        $query = "INSERT INTO Programs (candidate_id, program_title, program_description, program_video, program_affiche) VALUES ('$candidate_id', '$program_title', '$program_description', '$video', '$affiche')";
        $stmt = $db-> prepare($query);
        $stmt->execute();
    
        header("location: election_detail.php?election_id=".$_POST["election_id"]."&msg=$msg");
}
?>

<!doctype html>
<html lang="en">
  <head>
  	<title>Create Candidature</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="style.css">
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
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h1 class="heading-section" style="margin-top: -50px">Create your candidature's program</h1>
				</div>
			</div>
            <div class="d-flex" style="flex-direction: column; width: 600px; margin: auto">
			      		<div class="w-100">
			      			<h3 class="mb-4">Program details</h3>
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
                            <input type="hidden" name="election_id" value="<?php echo $_GET["election_id"]?>" />
                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary submit px-3">Add Program</button>
                            </div>  
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


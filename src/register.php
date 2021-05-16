<?php
include('config.php');
session_start();
if(isset($_POST['button'])) {


  if(empty($_POST['username'])) {
    echo "<script type='text/javascript'>alert('Username cannot be empty!');window.location.href='index.php';</script>";
  }
  else if(empty($_POST['pass'])) {
    echo "<script type='text/javascript'>alert('Password cannot be empty!');window.location.href='index.php';</script>";
  }
  else {
    $username = $_POST['username'];
    $password = $_POST['pass'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['e-mail'];
    $log_in_type = $_POST['inlineRadioOptions'];
    $sql = "select * from user where username='$username'";
    $student = mysqli_query($db,$sql);

    if(mysqli_num_rows($student) != 0) {
      echo "<script type='text/javascript'>alert('This user already exists!');window.location.href='index.php';</script>";
    }
    else {
      $insert_sql = "insert into user (username, email, password, name, surname) values (\"$username\", \"$email\", \"$password\", \"$name\", \"$surname\")";
      $student = mysqli_query($db,$insert_sql);

      $get_user = "select * from user where username='$username'";
      $user_query = mysqli_query($db, $get_user);
      $user_id = mysqli_fetch_array($user_query)['user_id'];

      if ($log_in_type == "Author") {
        echo "<script type='text/javascript'>alert('Author Ekledi!, $log_in_type');</script>";
        $insert_author_sql = "insert into author (user_id) values (\"$user_id\")";
        $author = mysqli_query($db, $insert_author_sql);
      }
      else if ($log_in_type == "Librarian") {
        echo "<script type='text/javascript'>alert('Librarian Ekledi!, $log_in_type, $user_id');</script>";
        $insert_librarian_sql = "insert into librarian (user_id) values (\"$user_id\")";
        $librarian = mysqli_query($db, $insert_librarian_sql);
      }

      echo "<script type='text/javascript'>alert('Success!, $log_in_type');window.location.href='index.php';</script>";
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>BookHub - Register</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
<!-- CSS only -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>

	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/background.jpeg');">
			<div class="wrap-login100 p-t-40 p-b-30">
				<form class="login100-form validate-form" action="" method="post">
					<span class="login100-form-title p-b-45">
						BookHub
					</span>

					<div class="wrap-input100 validate-input m-b-10" data-validate = "Username is required">
						<input class="input100" type="text" name="username" placeholder="Username">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input m-b-10" data-validate = "Password is required">
						<input class="input100" type="password" name="pass" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input m-b-10" data-validate = "Name is required">
						<input class="input100" type="text" name="name" placeholder="Name">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input m-b-10" data-validate = "Surname is required">
						<input class="input100" type="text" name="surname" placeholder="Surname">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input m-b-10" data-validate = "e-mail is required">
						<input class="input100" type="text" name="e-mail" placeholder="e-mail">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user"></i>
						</span>
					</div>

						<div class="form-check form-check-inline m-t-20">
						  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="User" required>
						  <label class="form-check-label" for="inlineRadio1">User</label>
						</div>
						<div class="form-check form-check-inline m-t-20">
						  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="Author" required>
						  <label class="form-check-label" for="inlineRadio2">Author</label>
						</div>
						<div class="form-check form-check-inline m-t-20 m-b-20">
						  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="Librarian" required>
						  <label class="form-check-label" for="inlineRadio3">Librarian</label>
							<div class="invalid-feedback" style="margin-left: 1em">Please choose an option</div>
						</div>

					<div class="container-login100-form-btn p-t-10">
						<button class="login100-form-btn" type="submit" name="button">
							Register
						</button>
					</div>

					<div class="text-center w-full p-t-25">
						<a class="txt1" href="./index.php">
							Login
							<i class="fa fa-long-arrow-right"></i>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>




<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>

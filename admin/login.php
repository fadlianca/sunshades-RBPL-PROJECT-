<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../admin/login_admin.css">
    <title>Sunshades | Login Admin</title>
</head>
<body>
<div class="container">
    <form action="" method="POST" class="login-email">
	<?php 
	require "inc/config.php";

	// Redirect to login page if admin session is already set
	if(!empty($_SESSION['iam_admin'])){
		header("Location: login.php");
		exit; // Ensure no further code is executed after redirection
	}

	// Handle form submission
	if(!empty($_POST)){
		extract($_POST);
		$email = mysqli_real_escape_string($connect, $email); // Escape input for security
		$password = md5($password); // Assuming md5 hashing is your choice; consider stronger hashing methods

		// Perform query
		$q = mysqli_query($connect, "SELECT * FROM `user` WHERE email='$email' AND password='$password' AND status='admin'") or die(mysqli_error($connect));
		
		// Check if query was successful
		if(mysqli_num_rows($q) > 0){
			$r = mysqli_fetch_object($q);
			$_SESSION['iam_admin'] = $r->id;
			header("Location: index.php");
			exit; // Ensure no further code is executed after redirection
		}else{
			// Alert message if login fails
			echo "<div class='alert alert-danger'>Maaf email dan password anda salah</div>";
		}
	}
?>
        <p class="login-text">Hello Admin!</p><br>
        <label>Email</label><br>
        <input type="email" class="form-control" name="email" placeholder="Email" required autofocus /><br>
        <label>Password</label><br>
        <input type="password" class="form-control" name="password" placeholder="Password" required /><br>
        <div class="input-group">
            <button type="submit" name="submit" class="btn btn-primary">Login</button>
        </div>
    </form>
    <div class="ftr">
        Sunshades. Copyright ©2023. All rights reserved
    </div>
</div>
</body>
</html>

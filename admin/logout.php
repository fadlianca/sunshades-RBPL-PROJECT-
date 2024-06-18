<?php require "inc/config.php"; ?>
<?php

	unset($_SESSION['iam_admin']);
	//session_destroy();
	header ("location: login.php");
?>
<?php
// Check if session is not active before starting it
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start the session if not already started
}

$connect = mysqli_connect("localhost", "root", "", "sunshades");

// Check database connection
if (!$connect) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Settings
$url = "http://localhost/sunshades/";
$title = "Sunshades | Website Pemesanan Kacamata";
$no = 1;

// Check if alert function already exists before defining it
if (!function_exists('alert')) {
    // Function alert
    function alert($command) {
        echo "<script>alert('" . $command . "');</script>";
    }
}

// Check if redir function already exists before defining it
if (!function_exists('redir')) {
    // Function redirect
    function redir($command) {
        echo "<script>document.location='" . $command . "';</script>";
    }
}

// Check if validate_admin_not_login function already exists before defining it
if (!function_exists('validate_admin_not_login')) {
    // Function to validate admin not logged in
    function validate_admin_not_login($command) {
        if (empty($_SESSION['iam_admin'])) {
            redir($command);
        }
    }
}

?>

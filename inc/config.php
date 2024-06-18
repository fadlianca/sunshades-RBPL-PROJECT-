<?php
error_reporting(0);
session_start();

$host = "localhost";
$username = "root";
$password = ""; // sesuaikan dengan password database Anda jika ada
$database = "sunshades";

$connect = mysqli_connect($host, $username, $password, $database);

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

$url = "http://localhost/sunshades/";
$title = "Sunshades | Website Pemesanan Kacamata";
$no = 1;

// Fungsi untuk menampilkan alert menggunakan JavaScript
if (!function_exists('alert')) {
    function alert($message) {
        echo "<script>alert('" . $message . "');</script>";
    }
}

// Fungsi untuk melakukan redirect menggunakan JavaScript
if (!function_exists('redir')) {
    function redir($url) {
        echo "<script>document.location='" . $url . "';</script>";
    }
}

// Fungsi untuk memvalidasi admin tidak login
if (!function_exists('validate_admin_not_login')) {
    function validate_admin_not_login($redirect_url) {
        if (empty($_SESSION['iam_admin'])) {
            redir($redirect_url);
        }
    }
}
?>

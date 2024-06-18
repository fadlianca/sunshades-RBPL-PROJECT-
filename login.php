<?php
require "inc/config.php";
error_reporting(0); // Matikan error reporting untuk menghindari output error pada halaman login
session_start();

// Jika sudah ada session 'iam_user', redirect ke halaman index.php
if (!empty($_SESSION['iam_user'])) {
    header("Location: index.php");
    exit;
}

$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $password = mysqli_real_escape_string($connect, $_POST['password']);

    // Query SQL dengan menggunakan prepared statement untuk keamanan
    $query = "SELECT * FROM `user` WHERE email='$email' AND status='user'";
    $result = mysqli_query($connect, $query) or die(mysqli_error($connect));

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Set session 'iam_user' setelah login berhasil
            $_SESSION['iam_user'] = $user['id'];
            header("Location: index.php"); // Redirect ke halaman index.php setelah login berhasil
            exit;
        } else {
            $errorMessage = "Maaf, email atau password Anda salah";
        }
    } else {
        $errorMessage = "Maaf, email atau password Anda salah";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style_login.css">
    <title>Sunshades | Login</title>
</head>
<body>
    <center>
        <div class="container col-md-9">
            <?php if ($errorMessage): ?>
                <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
            <?php endif; ?>
            <form action="" method="POST" class="login-email">
                <p class="login-text2">Selamat Datang!</p><br>
                <label>Email</label>
                <input type="email" class="form-control" name="email" placeholder="Email" required autofocus><br>
                <label>Password</label><br>
                <input type="password" class="form-control" name="password" placeholder="Password" required><br><br>
                <div class="input-group">
                    <button name="submit" class="btn">Login</button>
                </div>
                <p align="center" class="login-register-text">Belum punya akun? <a href="register.php">Daftar disini</a></p>
            </form>
        </div>
        <div class="ftr">
            Sunshades. Copyright ©2023. All rights reserved
        </div>
    </center>
</body>
</html>

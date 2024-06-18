<?php
require "inc/config.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Memastikan session sudah dimulai (sudah dijalankan di config.php)
if (!empty($_SESSION['iam_user'])) {
    header("Location: index.php");
    exit;
}

$errorMessage = '';
$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $telephone = mysqli_real_escape_string($connect, $_POST['telephone']);
    $alamat = mysqli_real_escape_string($connect, $_POST['alamat']);

    // Validasi input (diperlukan validasi yang lebih detail)
    if (empty($username) || empty($email) || empty($password) || empty($cpassword) || empty($telephone) || empty($alamat)) {
        $errorMessage = "Semua kolom harus diisi.";
    } elseif ($password !== $cpassword) {
        $errorMessage = "Konfirmasi password tidak sesuai.";
    } else {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into database
        $query = "INSERT INTO user (username, email, telephone, alamat, password, status) 
                  VALUES ('$username', '$email', '$telephone', '$alamat', '$hashed_password', 'user')";
        $result = mysqli_query($connect, $query);

        if ($result) {
            $successMessage = "Pendaftaran Akun Berhasil. Silahkan login.";
            // Redirect to login page after registration
            header("Refresh: 3; url=login.php"); // Redirect setelah 3 detik
        } else {
            $errorMessage = "Terjadi kesalahan dalam pengisian form. Silahkan coba lagi.";
            echo '<div class="alert alert-danger">' . $errorMessage . '</div>';
            echo mysqli_error($connect); // Tampilkan pesan error MySQL (untuk debugging)
        }
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
    <title>Sunshades | Register</title>
</head>
<body>
    <center>
        <div class="container col-md-9">
            <?php if ($errorMessage): ?>
                <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
            <?php endif; ?>
            <?php if ($successMessage): ?>
                <div class="alert alert-success"><?php echo $successMessage; ?></div>
            <?php endif; ?>
            <form action="" method="POST" class="login-email">
                <p class="login-text2">Daftar Akun</p><br>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username"
                           value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email"
                           value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="cpassword" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="cpassword" name="cpassword" required>
                </div>
                <div class="mb-3">
                    <label for="telephone" class="form-label">Telephone</label>
                    <input type="text" class="form-control" id="telephone" name="telephone"
                           value="<?= isset($_POST['telephone']) ? htmlspecialchars($_POST['telephone']) : '' ?>" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat"
                              required><?= isset($_POST['alamat']) ? htmlspecialchars($_POST['alamat']) : '' ?></textarea>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Register</button>
                <p class="login-register-text mt-3">Sudah punya akun? <a href="login.php">Login disini</a></p>
            </form>
        </div>
        <div class="ftr">
            Sunshades. Copyright ©2023. All rights reserved
        </div>
    </center>
</body>
</html>

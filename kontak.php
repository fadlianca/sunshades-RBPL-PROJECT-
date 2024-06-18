<?php
require "inc/config.php";
error_reporting(0);
session_start();

$errorMessage = '';
$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $review = mysqli_real_escape_string($connect, $_POST['review']);

    // Validasi input (opsional)
    if (empty($email) || empty($review)) {
        $errorMessage = "Email dan Review harus diisi.";
    } else {
        // Insert ke database
        $query = "INSERT INTO kontak (email, review) VALUES ('$email', '$review')";
        $result = mysqli_query($connect, $query);

        if ($result) {
            $successMessage = "Review Anda telah berhasil disimpan.";
            // Kosongkan form setelah berhasil disimpan (opsional)
            $_POST['email'] = '';
            $_POST['review'] = '';

            // Redirect ke halaman index.php setelah 2 detik
            header("refresh:2;url=index.php");
        } else {
            $errorMessage = "Terjadi kesalahan dalam menyimpan review Anda. Silakan coba lagi.";
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
    <title>Sunshades | Kontak</title>
</head>
<body>
    <div class="container col-md-9" style="margin-top: 80px;">
        <nav class="navbar navbar-default navbar-fixed-top navbar-blue">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php">
                        <img src="uploads/logo.png" alt="Sunshades Logo" style="max-height: 50px;">
                        Sunshades
                    </a>
                </div>
            </div>
        </nav>
        <h2>Kontak Kami</h2>
        <?php if ($errorMessage): ?>
            <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
        <?php endif; ?>
        <?php if ($successMessage): ?>
            <div class="alert alert-success"><?php echo $successMessage; ?></div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="review" class="form-label">Review</label>
                <textarea class="form-control" id="review" name="review" rows="5" required><?= isset($_POST['review']) ? htmlspecialchars($_POST['review']) : '' ?></textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Kirim</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

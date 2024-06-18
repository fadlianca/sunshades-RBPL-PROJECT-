<?php
require "inc/config.php";
session_start();

$errorMessage = '';
$successMessage = '';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fetch list of cities and shipping costs from your database
$query_kota = "SELECT kota_id, nama_kota, ongkir FROM kota";
$result_kota = mysqli_query($connect, $query_kota);

// Check if user is logged in and get user_id
$user_id = isset($_SESSION['iam_user']) ? $_SESSION['iam_user'] : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize inputs
    $tanggal_pesan = date('Y-m-d H:i:s');
    $tanggal_digunakan = isset($_POST['tanggal_digunakan']) ? mysqli_real_escape_string($connect, $_POST['tanggal_digunakan']) : '';
    $nama = isset($_POST['nama']) ? mysqli_real_escape_string($connect, $_POST['nama']) : '';
    $alamat = isset($_POST['alamat']) ? mysqli_real_escape_string($connect, $_POST['alamat']) : '';
    $kota_id = isset($_POST['kota_id']) ? intval($_POST['kota_id']) : 0; // Convert to integer
    $telephone = isset($_POST['telephone']) ? mysqli_real_escape_string($connect, $_POST['telephone']) : '';
    $status = 'belum lunas'; // Default value
    $read = '0';

    // Calculate the minimum allowed date
    $current_date = new DateTime();
    $min_date = $current_date->modify('+3 days')->format('Y-m-d');

    // Validate user_id and selected city
    if ($user_id == 0) {
        $errorMessage = "Silakan login untuk melanjutkan.";
    } elseif ($kota_id == 0) {
        $errorMessage = "Silakan pilih kota.";
    } elseif (empty($tanggal_digunakan) || empty($nama) || empty($alamat) || empty($telephone)) {
        $errorMessage = "Harap lengkapi semua kolom.";
    } elseif ($tanggal_digunakan < $min_date) {
        $errorMessage = "Tanggal digunakan harus minimal 3 hari dari hari ini.";
    } else {
        // Fetch the shipping cost based on selected city
        $query_ongkir = "SELECT ongkir FROM kota WHERE kota_id = $kota_id";
        $result_ongkir = mysqli_query($connect, $query_ongkir);
        
        if ($result_ongkir && mysqli_num_rows($result_ongkir) > 0) {
            $row_ongkir = mysqli_fetch_assoc($result_ongkir);
            $ongkir = $row_ongkir['ongkir'];

            // Insert order into database
            $query_insert_order = "INSERT INTO pesanan (tanggal_pesan, tanggal_digunakan, user_id, nama, alamat, kota_id, ongkir, telephone, `read`, status) 
                                  VALUES ('$tanggal_pesan', '$tanggal_digunakan', '$user_id', '$nama', '$alamat', '$kota_id', '$ongkir', '$telephone', '$read', '$status')";
            $result_insert_order = mysqli_query($connect, $query_insert_order);

            if ($result_insert_order) {
                $order_id = mysqli_insert_id($connect);

                // Insert order details (items in cart) into database
                $cart = unserialize($_SESSION['cart']);
                foreach ($cart as $produk_id => $jumlah) {
                    $query_produk = "SELECT * FROM produk WHERE id = '$produk_id'";
                    $result_produk = mysqli_query($connect, $query_produk);
                    if ($result_produk && mysqli_num_rows($result_produk) > 0) {
                        $row_produk = mysqli_fetch_assoc($result_produk);
                        $harga_per_item = $row_produk['harga'];
                        $total_harga = $jumlah * $harga_per_item;

                        // Insert detail pesanan
                        $query_insert_detail = "INSERT INTO detail_pesanan (pesanan_id, produk_id, qty, total_harga) 
                                                VALUES ('$order_id', '$produk_id', '$jumlah', '$total_harga')";
                        $result_insert_detail = mysqli_query($connect, $query_insert_detail);

                        if (!$result_insert_detail) {
                            $errorMessage = "Gagal menyimpan detail pesanan.";
                            break; // Keluar dari loop jika ada kesalahan
                        }
                    } else {
                        $errorMessage = "Produk dengan ID $produk_id tidak ditemukan.";
                        break; // Keluar dari loop jika ada kesalahan
                    }
                }

                if (empty($errorMessage)) {
                    // Clear cart session after successful order
                    unset($_SESSION['cart']);

                    // Set pesan sukses
                    $successMessage = "Pesanan Anda telah berhasil disimpan.";

                    // Redirect setelah beberapa detik
                    header("refresh:2;url=index.php");
                    exit;
                }
            } else {
                $errorMessage = "Terjadi kesalahan dalam menyimpan pesanan Anda.";
            }
        } else {
            $errorMessage = "Terjadi kesalahan dalam mengambil biaya pengiriman.";
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
    <title>Sunshades | Order</title>
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
        <h2>Buat Pesanan</h2>
        <?php if ($errorMessage): ?>
            <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
        <?php endif; ?>
        <?php if ($successMessage): ?>
            <div class="alert alert-success"><?php echo $successMessage; ?></div>
        <?php endif; ?>
        <?php if ($user_id == 0): ?>
            <p>Silakan <a href="login.php">login</a> untuk membuat pesanan.</p>
        <?php else: ?>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="tanggal_digunakan" class="form-label">Tanggal Digunakan</label>
                    <input type="date" class="form-control" id="tanggal_digunakan" name="tanggal_digunakan" required>
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="kota_id" class="form-label">Domisili</label>
                    <select class="form-control" id="kota_id" name="kota_id" required>
                        <option value="">Pilih Kota</option>
                        <?php while ($row = mysqli_fetch_assoc($result_kota)): ?>
                            <option value="<?php echo $row['kota_id']; ?>"><?php echo $row['nama_kota'] . ' - Ongkir: ' . number_format($row['ongkir']) . ' IDR'; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="telephone" class="form-label">Telephone</label>
                    <input type="text" class="form-control" id="telephone" name="telephone" required>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Pesan</button>
            </form>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

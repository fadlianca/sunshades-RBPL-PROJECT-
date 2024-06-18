<?php
require "inc/config.php";
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (empty($_SESSION['iam_user'])) {
    header("Location: index.php");
    exit; // Pastikan untuk keluar dari skrip setelah mengarahkan header
}

$user = mysqli_fetch_object(mysqli_query($connect, "SELECT * FROM user WHERE id='{$_SESSION['iam_user']}'"));

if (!empty($_GET['id'])) {
    $id_pesanan = $_GET['id'];

    if (!empty($_POST)) {
        $gambar = md5(date('Y-m-d H:i:s')) . $_FILES['gambar']['name'];
        extract($_POST);

        $q = mysqli_query($connect, "INSERT INTO pembayaran (id_pesanan, id_user, bukti_pembayaran, total, status, keterangan, created_at) VALUES ('$id_pesanan', '$_SESSION[iam_user]', '$gambar', '$bayar', 'verified', '$keterangan', NOW())");

        if ($q) {
            $upload = move_uploaded_file($_FILES['gambar']['tmp_name'], 'uploads/' . $gambar);
            if ($upload) {
                echo "<script>alert('Pembayaran berhasil.'); window.location.href='index.php';</script>";
            }
        }
    }

    $dataPesanan = mysqli_fetch_object(mysqli_query($connect, "SELECT * FROM pesanan WHERE id='$id_pesanan'"));
    if (!empty($dataPesanan)) {
        // Get verified payments for this order
        $qPembayaran = mysqli_query($connect, "SELECT * FROM pembayaran WHERE id_pesanan='$id_pesanan' AND status='verified'");
        $totalPembayaran = 0;
        while ($d = mysqli_fetch_object($qPembayaran)) {
            $totalPembayaran += $d->total;
        }

        // Calculate total order amount
        $qTotal = mysqli_query($connect, "SELECT dp.qty, p.harga FROM detail_pesanan dp JOIN produk p ON dp.produk_id = p.id WHERE dp.pesanan_id='$id_pesanan'");
        $totalOrder = 0;
        while ($row = mysqli_fetch_object($qTotal)) {
            $totalOrder += $row->qty * $row->harga;
        }
        $totalOrder += $dataPesanan->ongkir;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pembayaran</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <h3>Detail Pembayaran</h3>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Total:</strong> Rp. <?php echo number_format($totalOrder, 2, ',', '.'); ?></p>
                        <p><strong>Dibayar:</strong> Rp. <?php echo number_format($totalPembayaran, 2, ',', '.'); ?></p>
                        <p><strong>Kekurangan:</strong> Rp. <?php echo number_format($totalOrder - $totalPembayaran, 2, ',', '.'); ?></p>
                    </div>
                    <div class="col-md-6">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Bayar</label>
                                <input type="number" class="form-control" name="bayar" required>
                            </div>
                            <div class="form-group">
                                <label>Bukti Pembayaran</label>
                                <input type="file" class="form-control" name="gambar" required>
                            </div>
                            <div class="form-group">
                                <label>Keterangan</label>
                                <input type="text" class="form-control" name="keterangan" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Bayar</button>
                            <a href="pembayaran.php" class="btn btn-secondary">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js" integrity="sha384-7mivkQ5gCTMlLVj0jK4rFPtsEnUJv62RgtBFHvs7DCuMmM5Ax2w2j8pCWZKqKn2W" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+ew0+8P0X1rziCpLZ4APFYws/sqBUfmJHzh" crossorigin="anonymous"></script>
</body>

</html>

<?php
    } else {
        echo '<div class="alert alert-danger">Data pesanan tidak ditemukan atau tidak lengkap.</div>';
    }
} else {
    echo '<div class="alert alert-danger">Parameter tidak valid.</div>';
}
?>

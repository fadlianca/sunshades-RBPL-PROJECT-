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

require "layout/header.php";
?>

<div class="col-md-9 content-menu">
    <div class="col-md-12">
        <h3>Riwayat Pemesanan</h3>
        <p>Silakan pilih pesanan yang ingin Anda bayar.</p>
        <hr>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pemesan</th>
                    <th>Tanggal Pesan</th>
                    <th>Tanggal Digunakan</th>
                    <th>Kota</th>
                    <th>Biaya Ongkir</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $q = mysqli_query($connect, "SELECT * FROM pesanan WHERE user_id='{$_SESSION['iam_user']}' AND status='belum lunas'");
                while ($data = mysqli_fetch_object($q)) {
                ?>
                    <tr <?php if ($data->read == 0) {
                            echo 'style="background:#cce9f8 !important;"';
                        } ?>>
                        <th scope="row"><?php echo $no++; ?></th>
                        <td><?php echo $data->nama ?></td>
                        <td><?php echo substr($data->tanggal_pesan, 0, 10) ?></td>
                        <td><?php echo $data->tanggal_digunakan ?></td>
                        <td><?php echo $data->kota ?></td>
                        <td><?php echo $data->ongkir ?></td>
                        <td>
                            <a class="btn btn-sm btn-primary" href="pembayaran_verif.php?id=<?php echo $data->id; ?>">Bayar</a>
                            <a class="btn btn-sm btn-danger" href="pembayaran.php?act=delete&id=<?php echo $data->id; ?>">Batalkan</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php require "layout/footer.php"; ?>

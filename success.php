<?php
require "inc/config.php";
require "layout/header.php";
error_reporting(0);
session_start();

$user = mysqli_fetch_object(mysqli_query($connect, "SELECT * FROM user WHERE id='$_SESSION[iam_user]'"));

?>

<div class="col-md-9">

    <div class="alert alert-success">Transaksi Berhasil. Silahkan tunggu. Admin akan segera menghubungi anda.</div>

    <div class="row">
        <div class="col-md-12">
            <hr>
            <h4>Detail Pesanan yang Anda Beli:</h4>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Produk</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Harga *</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $pes = mysqli_fetch_array(mysqli_query($connect, "SELECT * FROM pesanan WHERE user_id='$_SESSION[iam_user]' ORDER BY id DESC LIMIT 1"));
                    $q = mysqli_query($connect, "SELECT * FROM detail_pesanan WHERE pesanan_id='$pes[id]'");
                    $ongkir = $pes['ongkir'];
                    $total = 0;
                    while ($data = mysqli_fetch_object($q)) {
                        $katpro = mysqli_fetch_object(mysqli_query($connect, "SELECT * FROM produk WHERE id='$data->produk_id'"));
                        $t = $data->qty * $katpro->harga;
                        $total += $t;
                    ?>
                        <tr>
                            <th scope="row"><?php echo $no++; ?></th>
                            <td><?php echo $katpro->nama ?></td>
                            <td><?php echo number_format($katpro->harga, 2, ',', '.') ?></td>
                            <td><?php echo $data->qty ?></td>
                            <td><?php echo number_format($t, 2, ',', '.') ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="4" class="text-center">
                            <h5><b>ONGKIR</b></h5>
                        </td>
                        <td class="text-bold">
                            <h5><b><?php echo number_format($ongkir, 2, ',', '.') ?></b></h5>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-center">
                            <h5><b>TOTAL HARGA</b></h5>
                        </td>
                        <td class="text-bold">
                            <h5><b><?php echo number_format($total + $ongkir, 2, ',', '.') ?></b></h5>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php require "layout/footer.php"; ?>

<?php
require "inc/config.php";
validate_admin_not_login("login.php");

require "inc/header.php";

?>

<div class="container">
    <?php
    if (!empty($_GET)) {
        if ($_GET['act'] == "info") {
            $qInfo = mysqli_query($connect, "SELECT * FROM info_faq LIMIT 1");
            $dInfo = mysqli_fetch_object($qInfo);
            if (!empty($_POST)) {
                extract($_POST);
                $query = mysqli_query($connect, "UPDATE info_faq SET info='$info' WHERE id='1'");
                if ($query) {
                    echo '<div class="alert alert-success">Info Pembayaran berhasil diupdate.</div>';
                } else {
                    echo '<div class="alert alert-danger">Gagal mengupdate info Pembayaran.</div>';
                }
            }
?>
            <div class="row">
                <div class="col-md-6">
                    <h3>FAQ</h3>
                    <form action="pembayaran.php?act=info" method="POST">
                        <textarea class="form-control" name="info" rows="5"><?php echo $dInfo->info; ?></textarea>
                        <br>
                        <input type="submit" name="submit" value="Submit" class="btn btn-success">
                    </form>
                </div>
            </div>
            <hr>
        <?php
        } elseif ($_GET['act'] == "verified" && isset($_GET['id'])) {
            $id_pembayaran = $_GET['id'];
            $updatePembayaran = mysqli_query($connect, "UPDATE pembayaran SET status='verified' WHERE id='$id_pembayaran'");
            if ($updatePembayaran) {
                echo '<div class="alert alert-success">Pembayaran telah diverifikasi.</div>';
                // Lakukan pengecekan jika total pembayaran mencukupi, maka ubah status pesanan menjadi lunas
                $query = mysqli_query($connect, "SELECT * FROM pembayaran WHERE id='$id_pembayaran'");
                $dataPembayaran = mysqli_fetch_object($query);
                $totalPembayaran = $dataPembayaran->total;

                $qPesanan = mysqli_query($connect, "SELECT * FROM pesanan WHERE id='$dataPembayaran->id_pesanan'");
                $dataPesanan = mysqli_fetch_object($qPesanan);
                $totalBayar = $dataPesanan->ongkir;

                $qDetail = mysqli_query($connect, "SELECT * FROM detail_pesanan WHERE pesanan_id='$dataPembayaran->id_pesanan'");
                while ($detail = mysqli_fetch_object($qDetail)) {
                    $qProduk = mysqli_query($connect, "SELECT * FROM produk WHERE id='$detail->produk_id'");
                    $produk = mysqli_fetch_object($qProduk);
                    $totalBayar += $produk->harga * $detail->qty;
                }

                if ($totalBayar <= $totalPembayaran) {
                    $updatePesanan = mysqli_query($connect, "UPDATE pesanan SET status='lunas' WHERE id='$dataPembayaran->id_pesanan'");
                    if ($updatePesanan) {
                        echo '<div class="alert alert-success">Status pesanan telah diubah menjadi lunas.</div>';
                    } else {
                        echo '<div class="alert alert-danger">Gagal mengubah status pesanan menjadi lunas.</div>';
                    }
                }
            } else {
                echo '<div class="alert alert-danger">Gagal memverifikasi pembayaran.</div>';
            }
        } elseif ($_GET['act'] == "detail" && isset($_GET['id'])) {
            $id_pembayaran = $_GET['id'];
            $query = mysqli_query($connect, "SELECT * FROM pembayaran WHERE id='$id_pembayaran'");
            $dataPembayaran = mysqli_fetch_object($query);
            if ($dataPembayaran) {
                $qPesanan = mysqli_query($connect, "SELECT * FROM pesanan WHERE id='$dataPembayaran->id_pesanan'");
                $dataPesanan = mysqli_fetch_object($qPesanan);
        ?>
                <div class="col-md-6">
                    <h3> Detail Pembayaran</h3>
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td>Nama</td>
                                <td><?php echo $dataPesanan->nama; ?></td>
                            </tr>
                            <tr>
                                <td>Total Pembayaran</td>
                                <td><?php echo "Rp. " . number_format($dataPembayaran->total, 2, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <td>Bukti Transaksi</td>
                                <td><a href="../uploads/<?php echo $dataPembayaran->file; ?>" target="_newtab">Bukti Transaksi</a></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td><?php echo $dataPembayaran->status; ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <?php if ($dataPembayaran->status == "pending") { ?>
                        <a href="pembayaran.php?act=verified&id=<?php echo $dataPembayaran->id; ?>" class="btn btn-sm btn-success">Verifikasi</a>
                    <?php } ?>
                </div>
            <?php
            } else {
                echo '<div class="alert alert-danger">Data pembayaran tidak ditemukan.</div>';
            }
        }
    }
    ?>
        <h4>Daftar Pembayaran Masuk (
        <?php
            $q = mysqli_query($connect, "SELECT * FROM pembayaran ORDER BY status ASC");
            $j = mysqli_num_rows($q); // Hitung jumlah baris hasil query
            echo $j;
        ?>)</h4>
    <a href="pembayaran.php?act=info" class="btn btn-info">Info</a>
    <hr>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Total</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $q = mysqli_query($connect, "SELECT * FROM pembayaran ORDER BY status ASC");
            $no = 1;
            while ($data = mysqli_fetch_object($q)) {
                $qUser = mysqli_query($connect, "SELECT * FROM user WHERE id='$data->id_user'");
                $user = mysqli_fetch_object($qUser);
            ?>
                <tr <?php if ($data->status == "pending") {
                        echo 'style="background:#cce9f8 !important;"';
                    } ?>>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $user->username; ?></td>
                    <td><?php echo "Rp. " . number_format($data->total, 2, ',', '.'); ?></td>
                    <td><?php echo $data->status; ?></td>
                    <td>
                        <a class="btn btn-sm btn-warning" href="pembayaran.php?act=detail&id=<?php echo $data->id; ?>">Detail</a>
                        <a class="btn btn-sm btn-success" href="detail_pesanan.php?id=<?php echo $data->id_pesanan; ?>">Pesanan</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div> <!-- /container -->

<?php require "inc/footer.php"; ?>

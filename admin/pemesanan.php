<?php
require "inc/config.php"; // Menggunakan jalur relatif yang benar

// Menghitung total pesanan yang belum dibaca
$qpesanan = mysqli_query($connect, "SELECT * FROM pesanan WHERE `read`='0'") or die(mysqli_error($connect));
$totalUnRead = mysqli_num_rows($qpesanan);

// Menghitung total pembayaran yang belum diverifikasi
$qPembayaran = mysqli_query($connect, "SELECT * FROM pembayaran WHERE `status`='pending'") or die(mysqli_error($connect));
$totalPending = mysqli_num_rows($qPembayaran);

// Query untuk mengambil data pesanan beserta detail pesanannya
$query_pemesanan = "
    SELECT 
        p.id, 
        p.tanggal_pesan, 
        p.tanggal_digunakan, 
        p.user_id, 
        p.nama, 
        p.alamat, 
        k.nama_kota AS kota, 
        p.ongkir, 
        p.telephone, 
        p.`read`, 
        p.status, 
        dp.produk_id, 
        dp.qty, 
        dp.total_harga
    FROM 
        pesanan p
    LEFT JOIN 
        detail_pesanan dp ON p.id = dp.pesanan_id
    LEFT JOIN 
        kota k ON p.kota_id = k.kota_id
    WHERE 
        p.`read` = '0'
"; // Ubah kondisi WHERE sesuai kebutuhan

$result_pemesanan = mysqli_query($connect, $query_pemesanan) or die(mysqli_error($connect));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">    
    <title>Administrator Web - <?php echo $title; ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap core CSS -->
    <link href="<?php echo $url ?>assets/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo $url ?>assets/bootstrap/css/datetimepicker.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?php echo $url ?>assets/css/navbar-fixed-top.css" rel="stylesheet">
    <link href="<?php echo $url ?>assets/css/full-slider.css" rel="stylesheet">
    <link href="<?php echo $url ?>assets/css/style.css" rel="stylesheet">
</head>
<body>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top navbar-blue">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Sun Shades</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>

    <div class="container" style="margin-top:20px;">
        <div class="row">
            <div class="col-md-3">
                <div style="background:#D9D9D9; width:100%; height:auto; padding-top:3px;padding-bottom:3px; padding-left:10px;">
                    <h4>CATEGORY</h4>
                </div>
                <ul class="kategori">
                    <li><a href="pembayaran.php">Data Pembayaran (Pending: <?php echo $totalPending; ?>)</a></li>
                    <li><a href="pemesanan.php">Data Pemesanan (Belum Dibaca: <?php echo $totalUnRead; ?>)</a></li>
                    <li><a href="produk.php">Data Stok Produk</a></li>
                </ul>
            </div>
            <div class="col-md-9">
                <!-- Konten lainnya di sini -->
                <h3>Data Pemesanan</h3>
                <!-- Menampilkan daftar pesanan yang belum dibaca -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Tanggal Pesan</th>
                            <th>Tanggal Digunakan</th>
                            <th>Nama Pelanggan</th>
                            <th>Alamat</th>
                            <th>Kota</th>
                            <th>Ongkir</th>
                            <th>Telephone</th>
                            <th>Status</th>
                            <th>Detail Pesanan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result_pemesanan)) {
                            echo "<tr>";
                            echo "<td>{$row['id']}</td>";
                            echo "<td>{$row['tanggal_pesan']}</td>";
                            echo "<td>{$row['tanggal_digunakan']}</td>";
                            echo "<td>{$row['nama']}</td>";
                            echo "<td>{$row['alamat']}</td>";
                            echo "<td>{$row['kota']}</td>";
                            echo "<td>Rp " . number_format($row['ongkir'], 0, ',', '.') . "</td>";
                            echo "<td>{$row['telephone']}</td>";
                            echo "<td>{$row['status']}</td>";
                            echo "<td>";
                            
                            // Menampilkan detail pesanan
                            echo "<ul>";
                            echo "<li>Produk ID: {$row['produk_id']}, Qty: {$row['qty']}, Total Harga: Rp " . number_format($row['total_harga'], 0, ',', '.') . "</li>";
                            echo "</ul>";
    
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="<?php echo $url ?>assets/bootstrap/js/jquery.min.js"></script>
    <script src="<?php echo $url ?>assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo $url ?>assets/bootstrap/js/moment.min.js"></script>
    <script src="<?php echo $url ?>assets/bootstrap/js/bootstrap-datetimepicker.min.js"></script>
</body>
</html>

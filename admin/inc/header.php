<?php
require "inc/config.php"; // Menggunakan require untuk mengambil konfigurasi

// Menghitung total pesanan yang belum dibaca
$qpesanan = mysqli_query($connect, "SELECT * FROM pesanan WHERE `read`='0'") or die(mysqli_error($connect));
$totalUnRead = mysqli_num_rows($qpesanan);

// Menghitung total pembayaran yang belum diverifikasi
$qPembayaran = mysqli_query($connect, "SELECT * FROM pembayaran WHERE `status`='pending'") or die(mysqli_error($connect));
$totalPending = mysqli_num_rows($qPembayaran);
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

<?php 
	require_once "inc/config.php";
	require_once "layout/header.php";
?>

<head>
    <title>Sunshades | Rekomendasi Untuk Anda</title>
</head>

<div class="col-md-9">
    <div class="row">
        <div class="col-md-12">
            <hr>
            <h3>Rekomendasi Untuk Anda</h3>
            <?php 
                $k = mysqli_query($connect, "SELECT * FROM produk ORDER BY id DESC LIMIT 9"); 
                while($data = mysqli_fetch_array($k)) {
            ?>
            <div class="col-md-4 content-menu">
                <a href="<?php echo $url; ?>menu.php?id=<?php echo $data['id'] ?>">
                    <img src="<?php echo $url; ?>uploads/<?php echo $data['gambar'] ?>" width="100%">
                    <h4><?php echo $data['nama'] ?></h4>
                </a>
                <p style="font-size:18px">Harga: Rp<?php echo number_format($data['harga'], 2, ',', '.') ?></p>
                <p>
                    <a href="<?php echo $url; ?>menu.php?id=<?php echo $data['id'] ?>" class="btn btn-success btn-sm" role="button">Lihat Detail</a>
                    <?php if(empty($_SESSION['iam_user'])) { ?>
                        <a href="<?php echo $url; ?>login.php" class="btn btn-info btn-sm" role="button">Pesan</a>
                    <?php } else { ?>
                        <a href="<?php echo $url; ?>keranjang.php?act=beli&produk_id=<?php echo $data['id'] ?>" class="btn btn-info btn-sm" role="button">Pesan</a>
                    <?php } ?>
                </p>
            </div>  
            <?php } ?>
        </div>
    </div>
</div>

<?php require "layout/footer.php"; ?>

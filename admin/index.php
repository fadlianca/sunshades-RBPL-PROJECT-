<?php
	require "inc/config.php";
	require "inc/header.php";
	if(empty($_SESSION['iam_admin'])) {
		header("Location: login.php");
	}
?>
<?php
	$q = mysqli_query($connect, "SELECT * FROM user WHERE id='$_SESSION[iam_admin]'");
	$u = mysqli_fetch_object($q);
?>
		<div class="container text-center">
    		<div class="col-md-9">
			<div class="row">
			<div class="col-md-12">
			<h3>Menu Terbaru</h3>
				<?php 
					$k = mysqli_query($connect, "SELECT * FROM produk ORDER BY id DESC limit 9"); 
					while($data = mysqli_fetch_array($k)){
				?>
				<div class="col-md-4 content-menu">
					<a href="<?php echo $url; ?><?php echo $data['id'] ?>">
						<img src="<?php echo $url; ?>uploads/<?php echo $data['gambar'] ?>" width="100%">
						<h4><?php echo $data['nama'] ?></h4>
					</a>
					<p style="font-size:18px">Harga: Rp<?php echo number_format($data['harga'], 2, ',', '.') ?></p>
				</div>  
				<?php } ?>
			</div>
			</div>
			</div> <!-- /container -->
			

<?php require "inc/footer.php"; ?>

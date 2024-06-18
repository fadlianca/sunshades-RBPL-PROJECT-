<?php 
	require "inc/config.php"; 
	validate_admin_not_login("login.php");
	
	if(isset($_GET['id'])) {
		$id = $_GET['id'];
		
		// Update status 'read' to 1
		$aa = mysqli_query($connect, "UPDATE pesanan SET `read`='1' WHERE id='$id'") or die(mysqli_error($connect));
		
		// Fetch pesanan data
		$q = mysqli_query($connect, "SELECT * FROM pesanan WHERE id='$id'");
		$data = mysqli_fetch_object($q);
		
		// Calculate total payment
		$dataPembayaran = mysqli_query($connect, "SELECT * FROM pembayaran WHERE id_pesanan='$data->id' AND status='verified'") or die (mysqli_error($connect));
		$totalPembayaran = 0;
		while ($d = mysqli_fetch_array($dataPembayaran)) {
			$totalPembayaran += $d['total'];
		}

		// Calculate total order price including shipping cost
		$q1 = mysqli_query($connect, "SELECT * FROM detail_pesanan WHERE pesanan_id='$data->id'");
		$totalBayar = 0;
		while ($data2 = mysqli_fetch_object($q1)) {
			$katpro1 = mysqli_query($connect, "SELECT * FROM produk WHERE id='$data2->produk_id'");
			$a = mysqli_fetch_object($katpro1);
			$totalBayar += ($a->harga * $data2->qty);
		}
		$totalBayar += $data->ongkir;
		
		// Get city and shipping cost
		$kota = isset($data->kota) ? $data->kota : "Tidak diketahui";
		$ongkir = $data->ongkir;
	}
	
	require "inc/header.php";
?> 
	
<div class="container">
	<h4 class="pull-left">Pesanan Detail</h4> 
	<a class="btn btn-sm btn-primary pull-right" href="pesanan.php">&laquo; Kembali</a>
	<br>
	<hr> 
	<div class="row col-md-12">
		<table class="table table-striped table-hover">
			<tr>
				<td width="200">Nama Pemesan</td> 
				<?php
					$katpro = mysqli_query($connect, "SELECT * FROM user WHERE id='$data->user_id'");
					$user = mysqli_fetch_array($katpro);
				?>
				<td><?php echo $user['username'] ?></td> 
			</tr>
			<tr>
				<td>Tanggal Pesan</td>  
				<td><?php echo substr($data->tanggal_pesan,0,10); ?></td> 
			</tr>
			<tr>
				<td>Tanggal Digunakan</td>  
				<td><?php echo $data->tanggal_digunakan ?></td> 
			</tr>
			<tr>
				<td>Telephone</td> 
				<td><?php echo $data->telephone ?></td> 
			</tr>
			<tr>
				<td>Alamat</td> 
				<td><?php echo $data->alamat ?></td> 
			</tr> 
			<tr>
				<td>Total Bayar</td>
				<td><b><?php echo "Rp. " . number_format($totalBayar, 2, ",", "."); ?></b></td>
			</tr>
			<tr>
				<td>Dibayar</td>
				<td><?php echo "Rp. " . number_format($totalPembayaran, 2, ",", "."); ?></td>
			</tr>
			<tr>
				<td>Kekurangan</td>
				<td><?php echo "Rp. " . number_format($totalBayar - $totalPembayaran, 2, ",", "."); ?></td>
			</tr>
			<tr>
				<td>Status</td>
				<td><?php echo $data->status; ?></td>
			</tr>
		</table>
	</div>
	
	<div class="row col-md-12"> 
		<h4>List Pesanan</h4> 
		<hr> 
		<table class="table table-striped table-hover"> 
			<thead> 
				<tr> 
					<th>#</th> 
					<th>Nama Produk</th> 
					<th>Harga Satuan</th> 
					<th>QTY</th> 
					<th>Harga *</th>   
				</tr> 
			</thead> 
			<tbody> 
				<?php 
					$no = 1;
					$q = mysqli_query($connect, "SELECT * FROM detail_pesanan WHERE pesanan_id='$data->id'");
					$total = 0;
					while ($data = mysqli_fetch_object($q)) { 
				?> 
					<tr> 
						<th scope="row"><?php echo $no++; ?></th> 
						<?php
							$katpro = mysqli_query($connect, "SELECT * FROM produk WHERE id='$data->produk_id'");
							$p = mysqli_fetch_object($katpro);
						?>
						<td><?php echo $p->nama ?></td> 
						<td><?php echo number_format($p->harga, 2, ',', '.') ?></td>  
						<td><?php echo $data->qty ?></td>
						<?php 
							$t = $data->qty * $p->harga; 
							$total += $t;
						?>
						<td><?php echo number_format($t, 2, ',', '.') ?></td>  
					</tr>
				<?php } ?>
				<tr>
					<td colspan="3" class="text-center">
						<h5><b>KOTA & ONGKIR</b></h5>
					</td>
					<td class="text-bold">
						<h5><b><?php echo $kota; ?></b></h5>
					</td>
					<td class="text-bold">
						<h5><b><?php echo number_format($ongkir, 2, ',', '.'); ?></b></h5>
					</td>
				</tr>
				<tr>
					<td colspan="4" class="text-center">
						<h5><b>TOTAL HARGA</b></h5>
					</td>
					<td class="text-bold">
						<h5><b><?php echo number_format($total + $ongkir, 2, ',', '.'); ?></b></h5>
					</td>
				</tr>
			</tbody> 
		</table>
	</div>
</div> <!-- /container -->

<?php require "inc/footer.php"; ?>

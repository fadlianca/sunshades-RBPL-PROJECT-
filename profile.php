<?php 
	require "inc/config.php";
	error_reporting(0);
	session_start();

	if (empty($_SESSION['iam_user'])) {
		header("Location: index.php");
		exit;
	}

	$user = mysqli_fetch_object(mysqli_query($connect, "SELECT * FROM user WHERE id='$_SESSION[iam_user]'"));
	require "layout/header.php";

	$q = mysqli_query($connect, "SELECT * FROM pesanan WHERE user_id='$_SESSION[iam_user]'");
	$j = mysqli_num_rows($q);
?> 

<div class="container mt-4">
	<div class="row">
		<div class="col-md-6">
			<h3>Profil Saya: <?php echo htmlspecialchars($user->nama); ?></h3>
			<hr>
			<table class="table table-striped">
				<tr>
					<td>Email</td>
					<td>:</td>
					<td><?php echo htmlspecialchars($user->email); ?></td>
				</tr>
				<tr>
					<td>Password</td>
					<td>:</td>
					<td>--- *** ---</td>
				</tr>
			</table>
		</div>
		<div class="col-md-6">
			<div class="content-menu">
				<h3>Riwayat Pemesanan</h3>
				<hr>
				<table class="table table-striped table-hover"> 
					<thead> 
						<tr> 
							<th>#</th> 
							<th>Nama Pemesan</th> 
							<th>Tanggal Pesan</th> 
							<th>Tanggal Digunakan</th> 
							<th>Telephone</th> 
							<th>Alamat</th>  
						</tr> 
					</thead> 
					<tbody> 
						<?php 
							$no = 1;
							while ($data = mysqli_fetch_object($q)) { 
						?> 
						<tr <?php if ($data->read == 0) echo 'style="background:#cce9f8 !important;"'; ?>> 
							<th scope="row"><?php echo $no++; ?></th> 
							<td><?php echo htmlspecialchars($data->nama); ?></td> 
							<td><?php echo substr(htmlspecialchars($data->tanggal_pesan), 0, 10); ?></td> 
							<td><?php echo htmlspecialchars($data->tanggal_digunakan); ?></td> 
							<td><?php echo htmlspecialchars($data->telephone); ?></td> 
							<td><?php echo htmlspecialchars($data->alamat); ?></td> 
						</tr>
						<?php } ?>
					</tbody> 
				</table> 
			</div>
		</div>
	</div> 
</div>

<?php require "layout/footer.php"; ?>

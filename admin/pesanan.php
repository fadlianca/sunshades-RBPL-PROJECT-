<?php 
	require "inc/config.php"; 
	validate_admin_not_login("login.php");
	
	if (!empty($_GET['act'])) {
		if ($_GET['act'] == 'delete' && isset($_GET['id'])) {
			$id = $_GET['id'];
			$q = mysqli_query($connect, "DELETE FROM pesanan WHERE id='$id'");
			if ($q) { 
				echo '<script>alert("Success");</script>'; 
				echo '<script>window.location.href = "pesanan.php";</script>'; 
			} else {
				echo '<script>alert("Failed to delete.");</script>';
			}
		}  
		
		if ($_GET['act'] == 'edit' && isset($_GET['id'])) {
			if (!empty($_POST)) {
				extract($_POST); 

				$id = $_GET['id'];
				$nama = mysqli_real_escape_string($connect, $nama);
				$tanggal_pesan = mysqli_real_escape_string($connect, $tanggal_pesan);
				$tanggal_digunakan = mysqli_real_escape_string($connect, $tanggal_digunakan);
				$user_id = mysqli_real_escape_string($connect, $user_id);
				$alamat = mysqli_real_escape_string($connect, $alamat);
				$telephone = mysqli_real_escape_string($connect, $telephone);
				$status = mysqli_real_escape_string($connect, $status);

				$q = mysqli_query($connect, "UPDATE pesanan SET nama='$nama', tanggal_pesan='$tanggal_pesan', tanggal_digunakan='$tanggal_digunakan', user_id='$user_id', alamat='$alamat', telephone='$telephone', status='$status' WHERE id='$id'") or die(mysqli_error($connect));
				if ($q) { 
					echo '<script>alert("Success");</script>'; 
					echo '<script>window.location.href = "pesanan.php";</script>'; 
				} else {
					echo '<script>alert("Failed to update.");</script>';
				}
			}
		}
	}
	
	require "inc/header.php";
?> 
	
<div class="container">
	<?php
		$q = mysqli_query($connect, "SELECT * FROM pesanan ORDER BY id DESC");
		$j = mysqli_num_rows($q);
	?>
	<h4>Daftar pesanan Masuk (<?php echo ($j > 0) ? $j : 0; ?>)</h4>
	<!--a class="btn btn-sm btn-primary" href="pesanan.php?act=create">Add Data</a-->
	<hr>
	<?php
		if (!empty($_GET['act']) && $_GET['act'] == 'edit' && isset($_GET['id'])) {
			$id = $_GET['id'];
			$data = mysqli_fetch_object(mysqli_query($connect, "SELECT * FROM pesanan WHERE id='$id'"));
	?>
		<div class="row col-md-6">
			<form action="pesanan.php?act=edit&id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
				<label>Orang Yang Mesan</label><br>
				<select name="user_id" required class="form-control"> 
					<?php
						$katpro = mysqli_query($connect, "SELECT * FROM user WHERE id='$data->user_id'");
						$kpa = mysqli_fetch_array($katpro);
					?>
					<option value="<?php echo $kpa['id']; ?>"><?php echo $kpa['username'] ?></option>
					<?php
						$katpro = mysqli_query($connect, "SELECT * FROM user");
						while ($kp = mysqli_fetch_array($katpro)) {
					?>
					<option value="<?php echo $kp['id']; ?>"><?php echo $kp['username'] ?></option>
					<?php } ?>
				</select><br>
				<label>Tanggal Pesan</label><br>
				<input type="text" class="form-control" name="tanggal_pesan" value="<?php echo substr($data->tanggal_pesan, 0, 10); ?>" required><br>
				<label>Tanggal Digunakan</label><br>
				<input type="text" class="form-control" name="tanggal_digunakan" value="<?php echo $data->tanggal_digunakan; ?>" required><br>
				<label>Nama</label><br>
				<input type="text" class="form-control" name="nama" value="<?php echo $data->nama; ?>" required><br>
				<label>Telephone</label><br>
				<input type="text" class="form-control" name="telephone" value="<?php echo $data->telephone; ?>" required><br>
				<label>Alamat</label><br>
				<input type="text" class="form-control" name="alamat" value="<?php echo $data->alamat; ?>" required><br>
				<label>Status</label><br>
				<select name="status" class="form-control" required>
					<option value="Belum Lunas" <?php echo ($data->status == 'Belum Lunas') ? 'selected' : ''; ?>>Belum Lunas</option>
					<option value="Lunas" <?php echo ($data->status == 'Lunas') ? 'selected' : ''; ?>>Lunas</option>
				</select><br>
				<input type="submit" name="form-edit" value="Simpan" class="btn btn-success">
			</form>
		</div>
		<div class="row col-md-12"><hr></div>
	<?php	
		} 
	?>

	<table class="table table-striped table-hover"> 
		<thead> 
			<tr> 
				<th>#</th> 
				<th>Nama Pemesan</th> 
				<th>Tanggal Pesan</th> 
				<th>Tanggal Digunakan</th> 
				<th>Telephone</th> 
				<th>Status</th> 
				<th>*</th> 
			</tr> 
		</thead> 
		<tbody> 
			<?php 
				$no = 1;
				while ($data = mysqli_fetch_object($q)) { 
			?> 
				<tr <?php if ($data->read == 0) { echo 'style="background:#cce9f8 !important;"'; } ?> > 
					<th scope="row"><?php echo $no++; ?></th> 
					<?php
						$katpro = mysqli_query($connect, "SELECT * FROM user WHERE id='$data->user_id'");
						$user = mysqli_fetch_array($katpro);
					?>
					<td><?php echo $data->nama ?></td> 
					<td><?php echo substr($data->tanggal_pesan, 0, 10) ?></td> 
					<td><?php echo $data->tanggal_digunakan ?></td> 
					<td><?php echo $data->telephone ?></td> 
					<td><?php echo $data->status ?></td> 
					<td>
						<a class="btn btn-sm btn-warning" href="detail_pesanan.php?id=<?php echo $data->id ?>">Detail</a>
						<a class="btn btn-sm btn-success" href="pesanan.php?act=edit&id=<?php echo $data->id ?>">Edit</a>
						<a class="btn btn-sm btn-danger" href="pesanan.php?act=delete&id=<?php echo $data->id ?>">Delete</a>
					</td> 
				</tr>
			<?php } ?>
		</tbody> 
	</table> 
</div> <!-- /container -->

<?php require "inc/footer.php"; ?>

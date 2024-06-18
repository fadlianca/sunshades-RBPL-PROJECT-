<?php
	require "inc/config.php"; 
	require "layout/header.php";	
?>
<div class="col-md-9">
	<div class="row">
		<h3>Frequently Ask Question</h3>
		<?php
			$q = mysqli_query($connect, "SELECT*FROM info_faq");
			$data = mysqli_fetch_object($q);
		?>
		<pre><?php echo $data->info; ?></pre>
	</div>
</div>

<?php
	require "layout/footer.php";
?>
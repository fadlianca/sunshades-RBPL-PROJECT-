<?php 
require "inc/config.php"; 
validate_admin_not_login("login.php");

require "inc/header.php";

if (!empty($_GET)) {
    if ($_GET['act'] == 'delete' && isset($_GET['id'])) {
        $id = $_GET['id'];
        $q = mysqli_query($connect, "DELETE FROM produk WHERE id='$id'");
        if ($q) { 
            echo '<script>alert("Data berhasil dihapus.");</script>';
            echo '<script>window.location.href = "produk.php";</script>';
            exit;
        } else {
            echo '<script>alert("Gagal menghapus data.");</script>';
            echo '<script>window.location.href = "produk.php";</script>';
            exit;
        }
    } elseif ($_GET['act'] == 'create') {
        if (!empty($_POST)) {
            $gambar = md5(date('Y-m-d H:i:s')) . $_FILES['gambar']['name'];
            extract($_POST);
            $deskripsi = isset($_POST['deskripsi']) ? $_POST['deskripsi'] : '';
            $q = mysqli_query($connect, "INSERT INTO produk VALUES(NULL,'$nama','$deskripsi','$gambar','$harga','$kategori_produk_id')");
            if ($q) {
                $upload = move_uploaded_file($_FILES['gambar']['tmp_name'], '../uploads/' . $gambar);
                if ($upload) {
                    echo '<script>alert("Data berhasil disimpan.");</script>';
                    echo '<script>window.location.href = "produk.php";</script>';
                    exit;
                } else {
                    echo '<script>alert("Gagal mengupload gambar.");</script>';
                }
            } else {
                echo '<script>alert("Gagal menyimpan data.");</script>';
            }
        }
    } elseif ($_GET['act'] == 'edit' && isset($_GET['id'])) {
        if (!empty($_POST)) {
            $id = $_GET['id'];
            $gambar = md5(date('Y-m-d H:i:s')) . $_FILES['gambar']['name'];
            extract($_POST);
            $deskripsi = isset($_POST['deskripsi']) ? $_POST['deskripsi'] : '';
            $q = mysqli_query($connect, "UPDATE produk SET nama='$nama', deskripsi='$deskripsi', gambar='$gambar', harga='$harga', kategori_produk_id='$kategori_produk_id' WHERE id='$id'");
            if ($q) {
                $upload = move_uploaded_file($_FILES['gambar']['tmp_name'], '../uploads/' . $gambar);
                if ($upload) {
                    echo '<script>alert("Data berhasil diubah.");</script>';
                    echo '<script>window.location.href = "produk.php";</script>';
                    exit;
                } else {
                    echo '<script>alert("Gagal mengupload gambar.");</script>';
                }
            } else {
                echo '<script>alert("Gagal mengubah data.");</script>';
            }
        }
    }
}
?>

<div class="container">
    <h4>Daftar Produk Masuk (
        <?php
            $q = mysqli_query($connect, "SELECT * FROM produk");
            $j = mysqli_num_rows($q); // Hitung jumlah baris hasil query
            echo $j;
        ?>)</h4>
    <a class="btn btn-sm btn-primary" href="produk.php?act=create">Tambah Data</a>
    <hr>

    <?php if (!empty($_GET['act']) && $_GET['act'] == 'create'): ?>
        <div class="row col-md-6">
            <form action="produk.php?act=create" method="post" enctype="multipart/form-data">
                <label>Kategori Produk</label><br>
                <select name="kategori_produk_id" required class="form-control">
                    <?php
                    $katpro = mysqli_query($connect, "SELECT * FROM kategori_produk");
                    while ($kp = mysqli_fetch_array($katpro)) {
                        echo '<option value="' . $kp['id'] . '">' . $kp['nama'] . '</option>';
                    }
                    ?>
                </select><br>
                <label>Nama</label><br>
                <input type="text" class="form-control" name="nama" required><br>
                <label>Deskripsi</label><br>
                <textarea class="form-control" name="deskripsi" required></textarea><br>
                <label>Gambar</label><br>
                <input type="file" class="form-control" name="gambar" required><br>
                <label>Harga</label><br>
                <input type="number" class="form-control" name="harga" required><br>
                <input type="submit" name="form-input" value="Simpan" class="btn btn-success">
            </form>
        </div>
    <?php elseif (!empty($_GET['act']) && $_GET['act'] == 'edit' && isset($_GET['id'])):
        $id = $_GET['id'];
        $data = mysqli_fetch_object(mysqli_query($connect, "SELECT * FROM produk WHERE id='$id'"));
        ?>
        <div class="row col-md-6">
            <form action="produk.php?act=edit&id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
                <label>Kategori Produk</label><br>
                <select name="kategori_produk_id" required class="form-control">
                    <?php
                    $katpro = mysqli_query($connect, "SELECT * FROM kategori_produk");
                    while ($kp = mysqli_fetch_array($katpro)) {
                        $selected = ($kp['id'] == $data->kategori_produk_id) ? 'selected' : '';
                        echo '<option value="' . $kp['id'] . '" ' . $selected . '>' . $kp['nama'] . '</option>';
                    }
                    ?>
                </select><br>
                <label>Nama</label><br>
                <input type="text" class="form-control" name="nama" value="<?php echo $data->nama; ?>"><br>
                <label>Deskripsi</label><br>
                <textarea class="form-control" name="deskripsi" required><?php echo $data->deskripsi; ?></textarea><br>
                <label>Gambar</label><br>
                <input type="file" class="form-control" name="gambar"><br>
                <label>Harga</label><br>
                <input type="number" class="form-control" name="harga" value="<?php echo $data->harga; ?>"><br>
                <input type="submit" name="form-edit" value="Simpan" class="btn btn-success">
            </form>
        </div>
    <?php endif; ?>

    <div class="row col-md-12"><hr></div>

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th width="70px">Gambar</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>*</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $q = mysqli_query($connect, "SELECT * FROM produk");
            $no = 1;
            while ($data = mysqli_fetch_object($q)) {
            ?>
                <tr>
                    <th scope="row"><?php echo $no++; ?></th>
                    <td><img src="../uploads/<?php echo $data->gambar; ?>" width="100%"></td>
                    <td><?php echo $data->nama; ?></td>
                    <td><?php echo number_format($data->harga, 2, ',', '.'); ?></td>
                    <td>
                        <a class="btn btn-sm btn-success" href="produk.php?act=edit&id=<?php echo $data->id; ?>">Edit</a>
                        <a class="btn btn-sm btn-danger" href="produk.php?act=delete&id=<?php echo $data->id; ?>">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div> <!-- /container -->

<?php require "inc/footer.php"; ?>

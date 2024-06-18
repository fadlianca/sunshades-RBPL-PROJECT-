<?php 
require "inc/config.php";
require "layout/header.php";
error_reporting(0);
session_start();

// Inisialisasi session cart jika kosong
if(empty($_SESSION['cart'])){
    $_SESSION['cart'] = '';
}

// Proses beli produk
if(!empty($_GET['produk_id']) && $_GET['act'] == 'beli'){
    $cart = unserialize($_SESSION['cart']);
    if($cart == ''){
        $cart = [];
    }

    $pid = $_GET['produk_id'];
    $qty = 1;

    // Update keranjang
    if(isset($_GET['update_cart'])){
        if(isset($cart[$pid])){
            if ($_GET['qty'] >= 1){
                $cart[$pid] = $_GET['qty'];
            }
        }
    }
    // Hapus produk dari keranjang
    elseif(isset($_GET['delete_cart'])){
        if(isset($cart[$pid])){
            unset($cart[$pid]);
        }   
    }
    // Tambah produk ke keranjang
    else {
        if(isset($cart[$pid])){
            $cart[$pid] += $qty;
        } else {
            $cart[$pid] = $qty;
        }
    }

    // Simpan kembali keranjang ke session
    $_SESSION['cart'] = serialize($cart);
    header("Location: keranjang.php");
    exit;
}
?>

<div class="col-md-9">
    <div class="row">
        <div class="col-md-12">
            <h2>Keranjang Saya</h2>
            <table class="table table-striped" style="width:100%">
                <thead>
                    <tr style="background:#c3ebf8;font-weight:bold;">
                        <td style="width:15%">Produk</td>
                        <td style="width:40%">Details</td>
                        <td style="width:15%">Jumlah</td>
                        <td style="width:15%">Total</td>
                        <td style="width:5%" class="delete">&nbsp;</td>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total = 0;
                    $cart = unserialize($_SESSION['cart']);
                    if($cart == ''){
                        $cart = [];
                    }
                    foreach($cart as $id => $qty){
                        // Query untuk mengambil detail produk dari database
                        $query = "SELECT * FROM produk WHERE id='$id'";
                        $result = mysqli_query($connect, $query);
                        if(mysqli_num_rows($result) > 0){
                            $product = mysqli_fetch_array($result);
                            $t = $qty * $product['harga'];
                            $total += $t;
                            ?>
                            <tr class="barang-shop">
                                <td class="CartProductThumb">
                                    <div>
                                        <a href="<?php echo $url; ?>menu.php?id=<?php echo $product['id'] ?>">
                                            <img src="<?php echo $url.'uploads/'.$product['gambar']; ?>" alt="img" width="120px">
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="CartDescription">
                                        <h4>
                                            <a href="<?php echo $url; ?>menu.php?id=<?php echo $product['id'] ?>">
                                                <?php echo $product['nama'] ?>
                                            </a>
                                        </h4>
                                        <div class="price"><?php echo "Rp".number_format($product['harga'], 2, ',', '.') ?></div>
                                    </div>
                                </td> 
                                <td>
                                    <form action="<?php echo $url; ?>keranjang.php" method="GET"> 
                                        <input type="hidden" name="update_cart" value="update">
                                        <input type="hidden" name="act" value="beli">
                                        <input type="hidden" name="produk_id" value="<?= $id ?>">
                                        <input class="form-control" type="number" name="qty" value="<?php echo $qty; ?>" onchange="this.form.submit()">
                                    </form>
                                </td>
                                <td class="price"><?php echo "Rp".number_format($t, 2, ',', '.') ?></td>
                                <td>
                                    <a href="<?php echo $url; ?>keranjang.php?delete_cart=yes&act=beli&produk_id=<?php echo $id; ?>" title="Delete">
                                        <i class="glyphicon glyphicon-trash fa-2x"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php 
                        }
                    }
                    ?>
                    <tr style="background:#c3ebf8;font-weight:bold;">
                        <td colspan="3">SUB TOTAL</td>
                        <td><?php echo "Rp".number_format($total, 2, ',', '.') ?></td>
                        <td>&nbsp;</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="float:right;" class="col-sm-6 col-md-6">
            <h4><b>Total Keranjang Belanja</b></h4>
            <table class="table table-bordered">
                <tr>
                    <td style="background:#fafafa;"><b>Total</b></td>
                    <td><b><?php echo "Rp".number_format($total, 2, ',', '.') ?></b></td>
                </tr>
            </table>
            <form action="<?php echo $url.'order.php' ?>" method="POST"> 
                <input type="hidden" name="tanggal_digunakan" value="<?php echo date('Y-m-d H:i:s'); ?>">
                <input type="hidden" name="total_harga" value="<?php echo $total; ?>">
                <button <?php echo ($total == 0)? 'disabled' : '' ?> type="submit" class="btn btn-primary">Selesai Belanja &raquo;</button>
            </form>
        </div>
    </div> 
</div>  
<?php require "layout/footer.php"; ?>

<?php
include '../lib/koneksi.php';

$stmt = $conn->prepare("SELECT products.*, categories.name AS category_name FROM products LEFT JOIN categories ON products.category_id = categories.id");
$stmt->execute();
$products = $stmt->fetchAll();

if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'error_fk') {
        echo "<script>alert('Produk tidak bisa dihapus karena sudah digunakan dalam transaksi.');</script>";
    } elseif ($_GET['msg'] == 'error') {
        echo "<script>alert('Terjadi kesalahan saat menghapus produk.');</script>";
    }
}

?>
       
    <div class="container">
        <h1>Daftar Produk</h1>
       <center>
        <a href="petugas.php?page=tambah_produk" class="btn"><i class="fa fa-plus"></i> Tambah Produk</a>
        </center>
         <table>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Kategori</th>
                <th>Stok</th>
            </tr>
            <?php foreach ($products as $product): ?>
            <tr>
                <td><?php echo $product['id']; ?></td>
                <td><?php echo $product['name']; ?></td>
                <td><?php echo $product['price']; ?></td>
                <td><?php echo $product['category_name']; ?></td>
                <td><?php echo $product['stok']; ?></td>
            </tr>    
            <?php endforeach; ?>
        </table>
       <center>
         <a href="petugas.php?page=kategori" class="btn m-5">Kategori</a>
         </center>
    </div>
      

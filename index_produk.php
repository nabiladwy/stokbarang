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
        <center>
        <b>Daftar Produk</b><br>
        <a href="admin.php?page=create_produk" class="btn"><i class="fa fa-plus"></i> Tambah Produk</a>
         </center>
         <table>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
            <?php foreach ($products as $product): ?>
            <tr>
                <td><?php echo $product['id']; ?></td>
                <td><?php echo $product['name']; ?></td>
                <td><?php echo $product['price']; ?></td>
                <td><?php echo $product['category_name']; ?></td>
                <td><?php echo $product['stok']; ?></td>
                <td class="action">
                    <a href="edit_produk.php?id=<?php echo $product['id']; ?>" class="edit"><i class="fa fa-edit"></i> Edit</a>
                    <a href="delete_produk.php?id=<?php echo $product['id']; ?>" class="delete" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');"><i class="fa fa-trash"></i> Hapus</a>
                </td>
            </tr>    
            <?php endforeach; ?>
        </table>
      <center>  <a href="admin.php?page=kategori" class="btn m-3">Kategori</a></center>
       
    </div>
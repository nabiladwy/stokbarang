<?php
include '../lib/koneksi.php';
$stmt = $conn->prepare("SELECT * FROM categories");
$stmt->execute();
$categories = $stmt->fetchAll();

if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'error_fk') {
        echo "<script>alert('Kategori tidak bisa dihapus karena sudah digunakan dalam transaksi.');</script>";
    } elseif ($_GET['msg'] == 'error') {
        echo "<script>alert('Terjadi kesalahan saat menghapus Kategori.');</script>";
    }
}
?>

       
    <div class="container">
        <h1>Daftar Kategori</h1>
       <center> <a href="petugas.php?page=tambah_kategori" class="btn"><i class="fa fa-plus"></i> Tambah Kategori</a></center>
        <table>
            <tr>
                <th>ID</th>
                <th>Nama</th>
            </tr>
            <?php foreach ($categories as $category): ?>
            <tr>
                <td><?php echo $category['id']; ?></td>
                <td><?php echo $category['name']; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
   <center> <a href="petugas.php?page=produk" class="back-link">Kembali</a> </center>


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
<center>
    <div class="container">
        <b>Daftar Kategori</b><br>
        <a href="admin.php?page=create_kategori" class="btn"><i class="fa fa-plus"></i> Tambah Kategori</a>
        <table>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Aksi</th>
            </tr>
            <?php foreach ($categories as $category): ?>
            <tr>
                <td><?php echo $category['id']; ?></td>
                <td><?php echo $category['name']; ?></td>
                <td class="action">
                    <a href="edit_kategori.php?id=<?php echo $category['id']; ?>" class="edit"><i class="fa fa-edit"></i> Edit</a>
                    <a href="delete_kategori.php?id=<?php echo $category['id']; ?>" class="delete" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');"><i class="fa fa-trash"></i> Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <a href="admin.php?page=produk" class="back-link">Kembali</a>
    </center>
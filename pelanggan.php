<?php
include '../lib/koneksi.php';

$stmt = $conn->prepare("SELECT client.*, tarif.name AS tarif_name FROM client LEFT JOIN tarif ON client.tarif_id = tarif.id  ORDER BY id ASC");
$stmt->execute();
$products = $stmt->fetchAll();

if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'error_fk') {
        echo "<script>alert('Pelanggan tidak bisa dihapus karena sudah digunakan dalam transaksi.');</script>";
    } elseif ($_GET['msg'] == 'error') {
        echo "<script>alert('Terjadi kesalahan saat menghapus pelanggan.');</script>";
    }
}
?>
        
        <div class="container">
        <center>
        <b>Daftar Pelanggan</b> <br><br>
        <a href="admin.php?page=create_pel" class="btn"><i class="fa fa-plus"></i> Tambah</a>
        </center>
         <table>
            <tr>
                <th>ID</th>
                <th>Nama</th>
               <!-- <th>Tarif</th>-->
                <th>Alamat</th>
                <!--<th>Riwayat</th>
                <th>Jumlah</th>-->
                <th>Telepon</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
            <?php foreach ($products as $product): ?>
            <tr>
                <td><?php echo $product['id']; ?></td>
                <td><?php echo $product['nama']; ?></td>
                <!--<td><?php echo $product['tarif_name']; ?></td>-->
                <td><?php echo $product['alamat']; ?></td>
                <!--<td><?php echo $product['riwayat']; ?></td>
                <td><?php echo $product['jumlah']; ?></td>-->
                <td><?php echo $product['telepon']; ?></td>
                <td><?php echo $product['tanggal']; ?></td>
                <td class="action">
                    <a href="edit_pel.php?id=<?php echo $product['id']; ?>" class="edit"><i class="fa fa-edit"></i> Edit</a>
                    <a href="delete_pel.php?id=<?php echo $product['id']; ?>" class="delete" onclick="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?');"><i class="fa fa-trash"></i> Hapus</a>
                </td>
            </tr>    
            <?php endforeach; ?>
        </table>
    </div>

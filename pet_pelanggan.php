<?php
include '../lib/koneksi.php';

$stmt = $conn->prepare("SELECT client.*, tarif.name AS tarif_name FROM client LEFT JOIN tarif ON client.tarif_id = tarif.id  ORDER BY id ASC");
$stmt->execute();
$products = $stmt->fetchAll();

?>
     
    <div class="container">
        <h1>Daftar Pelanggan</h1>
      <center> <a href="petugas.php?page=tambah_pel" class="btn"><i class="fa fa-plus"></i> Tambah</a> </center>
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
                <td> <a href="editpel.php?id=<?php echo $product['id']; ?>" class="edit" style="button-color: #b38600; color: white; text-decoration: none; padding: 4px 8px; border: 1px solid #b38600; border-radius: 4px;"><i class="fa fa-edit"></i> Edit</a></td>
            </tr>    
            <?php endforeach; ?>
        </table>
    </div>
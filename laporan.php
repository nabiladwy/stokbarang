<?php
include '../lib/koneksi.php';

// Ambil data transaksi yang dikelompokkan per tanggal
$stmt = $conn->prepare("
    SELECT DATE(tanggal) AS tanggal, 
           SUM(jumlah) AS total_item, 
           SUM(total) AS total_penjualan 
    FROM transaksi 
    GROUP BY DATE(tanggal) 
    ORDER BY DATE(tanggal) DESC
");
$stmt->execute();
$laporan = $stmt->fetchAll();
?>

<center><b>Laporan Penjualan Harian</b></center><br>


<table border="1">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Total Produk Terjual</th>
            <th>Total Penjualan (Rp)</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($laporan as $row): ?>
            <tr>
                <td><?= $row['tanggal']; ?></td>
                <td><?= $row['total_item']; ?></td>
                <td>Rp<?= number_format($row['total_penjualan']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<form action="excel.php" method="post">
    <center>
        <button type="submit" class="btn m-5" style="width: 100px;">Ekspor</button>
        </center>
</form>


<?php
include '../lib/koneksi.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_penjualan_harian.xls");
header("Pragma: no-cache");
header("Expires: 0");

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


<?php
include '../lib/koneksi.php';

// Ambil data pelanggan
$stmtClient = $conn->prepare("SELECT id, nama FROM client");
$stmtClient->execute();
$clients = $stmtClient->fetchAll();

// Ambil data produk
$stmtProduk = $conn->prepare("SELECT id, name, price FROM products");
$stmtProduk->execute();
$products = $stmtProduk->fetchAll();

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_id = $_POST['client_id'];
    $product_id = $_POST['product_id'];
    $jumlah = $_POST['jumlah'];

    $stmtPrice = $conn->prepare("SELECT price FROM products WHERE id = ?");
    $stmtPrice->execute([$product_id]);
    $product = $stmtPrice->fetch();

    $total = $product['price'] * $jumlah;

    $stmtInsert = $conn->prepare("INSERT INTO transaksi (client_id, product_id, jumlah, total) VALUES (?, ?, ?, ?)");
    $stmtInsert->execute([$client_id, $product_id, $jumlah, $total]);
    // Kurangi stok produk
    $stmtUpdateStok = $conn->prepare("UPDATE products SET stok = stok - ? WHERE id = ?");
    $stmtUpdateStok->execute([$jumlah, $product_id]);


    //echo "<script>alert('Transaksi berhasil ditambahkan!'); window.location.href='admin.php?page=transaksi';</script>";
}

$stmtTransaksi = $conn->prepare("
    SELECT transaksi.*, client.nama AS nama_client, products.name AS nama_produk 
    FROM transaksi 
    JOIN client ON transaksi.client_id = client.id 
    JOIN products ON transaksi.product_id = products.id 
    ORDER BY transaksi.id DESC
");
$stmtTransaksi->execute();
$transaksis = $stmtTransaksi->fetchAll();
?>

<div class="main-wrapper">

    <div class="table-container">
       <center> <b>Data Transaksi</b> </center><br>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pelanggan</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transaksis as $trx): ?>
                    <tr>
                        <td><?= $trx['id']; ?></td>
                        <td><?= $trx['nama_client']; ?></td>
                        <td><?= $trx['nama_produk']; ?></td>
                        <td><?= $trx['jumlah']; ?></td>
                        <td>Rp<?= number_format($trx['total']); ?></td>
                        <td><?= $trx['tanggal']; ?></td>
                        <td class="action">
                            <a href="edit_transaksi.php?id=<?= $trx['id']; ?>" class="edit"><i class="fa fa-edit"></i> Edit</a>
                            <a href="delete_transaksi.php?id=<?= $trx['id']; ?>" class="delete" onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?');"><i class="fa fa-trash"></i> Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
                </div>

</div>
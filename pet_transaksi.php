<?php
include '../lib/koneksi.php';

// Ambil data pelanggan
$stmtClient = $conn->prepare("SELECT id, nama FROM client");
$stmtClient->execute();
$clients = $stmtClient->fetchAll();

// Ambil data produk
$stmtProduk = $conn->prepare("SELECT id, name, price, stok FROM products");
$stmtProduk->execute();
$products = $stmtProduk->fetchAll();

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_id = (int)$_POST['client_id'];
    $product_id = (int)$_POST['product_id'];
    $jumlah = (int)$_POST['jumlah'];

    $stmtProduct = $conn->prepare("SELECT price, stok FROM products WHERE id = ?");
    $stmtProduct->execute([$product_id]);
    $product = $stmtProduct->fetch();

    if (!$product) {
        echo "<script>alert('Produk tidak ditemukan.'); window.location.href='petugas.php?page=transaksi';</script>";
        exit;
    }

    if ($jumlah > (int)$product['stok']) {
        echo "<script>alert('Stok produk tidak mencukupi. Maksimal pembelian: {$product['stok']}'); window.location.href='petugas.php?page=transaksi';</script>";
        exit;
    }

    $total = $product['price'] * $jumlah;

    $stmtInsert = $conn->prepare("INSERT INTO transaksi (client_id, product_id, jumlah, total) VALUES (?, ?, ?, ?)");
    $stmtInsert->execute([$client_id, $product_id, $jumlah, $total]);

    $stmtUpdateStok = $conn->prepare("UPDATE products SET stok = stok - ? WHERE id = ?");
    $stmtUpdateStok->execute([$jumlah, $product_id]);

    echo "<script>alert('Transaksi berhasil ditambahkan!'); window.location.href='petugas.php?page=transaksi';</script>";
    exit;
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
    <div class="form-container">
        <center><b>Form Transaksi</b></center><br>
        <form method="POST">
            <label for="client_id">Pelanggan:</label>
            <select name="client_id" required>
                <?php foreach ($clients as $client): ?>
                    <option value="<?= $client['id']; ?>"><?= $client['nama']; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="product_id">Produk:</label>
            <select name="product_id" required>
                <?php foreach ($products as $product): ?>
                    <option value="<?= $product['id']; ?>">
                        <?= $product['name']; ?> - Rp<?= number_format($product['price']); ?> (Stok: <?= $product['stok']; ?>)
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="jumlah">Jumlah:</label>
            <input type="number" name="jumlah" min="1" required>

            <button type="submit">Tambah Transaksi</button>
        </form>
    </div>

    <div class="table-container">
        <center><b>Data Transaksi</b></center><br>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pelanggan</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Tanggal</th>
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
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

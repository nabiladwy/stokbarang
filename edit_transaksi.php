<?php
include '../lib/koneksi.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM transaksi WHERE id = :id");
$stmt->execute(['id' => $id]);
$transaksi = $stmt->fetch();

// Ambil data client
$client_stmt = $conn->prepare("SELECT * FROM client");
$client_stmt->execute();
$clients = $client_stmt->fetchAll();

// Ambil data produk
$product_stmt = $conn->prepare("SELECT * FROM products");
$product_stmt->execute();
$products = $product_stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $client_id = $_POST['client_id'];
    $product_id = $_POST['product_id'];
    $jumlah_baru = $_POST['jumlah'];
    // Ambil harga produk yang dipilih
    $harga_stmt = $conn->prepare("SELECT price FROM products WHERE id = :id");
    $harga_stmt->execute(['id' => $product_id]);
    $harga_produk = $harga_stmt->fetchColumn();

    // Hitung total
    $total = $harga_produk * $jumlah_baru;

    $tanggal = $_POST['tanggal'];

    // Ambil data transaksi lama
    $stmt_old = $conn->prepare("SELECT * FROM transaksi WHERE id = :id");
    $stmt_old->execute(['id' => $id]);
    $transaksi_lama = $stmt_old->fetch();
    $jumlah_lama = $transaksi_lama['jumlah'];
    $product_id_lama = $transaksi_lama['product_id'];

    // Jika produk tidak diganti
    if ($product_id == $product_id_lama) {
        $selisih = $jumlah_baru - $jumlah_lama;

        // Update stok produk
        $update_stok = $conn->prepare("UPDATE products SET stok = stok - :selisih WHERE id = :product_id");
        $update_stok->execute([
            'selisih' => $selisih,
            'product_id' => $product_id
        ]);
    } else {
        // Kembalikan stok produk lama
        $restore_stok = $conn->prepare("UPDATE products SET stok = stok + :jumlah WHERE id = :product_id");
        $restore_stok->execute([
            'jumlah' => $jumlah_lama,
            'product_id' => $product_id_lama
        ]);

        // Kurangi stok produk baru
        $kurangi_stok = $conn->prepare("UPDATE products SET stok = stok - :jumlah WHERE id = :product_id");
        $kurangi_stok->execute([
            'jumlah' => $jumlah_baru,
            'product_id' => $product_id
        ]);
    }

    // Update data transaksi
    $stmt = $conn->prepare("UPDATE transaksi SET client_id = :client_id, product_id = :product_id, jumlah = :jumlah, total = :total, tanggal = :tanggal WHERE id = :id");
    $stmt->execute([
        'client_id' => $client_id,
        'product_id' => $product_id,
        'jumlah' => $jumlah_baru,
        'total' => $total,
        'tanggal' => $tanggal,
        'id' => $id
    ]);

    echo "<script> window.location.href='admin.php?page=transaksi';</script>";
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Transaksi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #000;
            text-align: center;
            color: #f2f1f7;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            background: #0d0d0d;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
        }
        h1 {
            color: #fcfcff;
        }
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }
        label {
            display: block;
            font-size: 16px;
            color: white;
            margin-bottom: 5px;
        }
        input, select {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #6c5f9e;
            background: #1a1a1a;
            color: white;
        }
        .btn {
            padding: 10px 20px;
            margin-top: 10px;
            color: white;
            background: #6c5f9e;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn:hover {
            background: #5a4d88;
        }
        .back-link {
            display: inline-block;
            margin-top: 10px;
            color: #eae9ee;
            text-decoration: none;
            font-size: 16px;
        }
        .back-link:hover {
            color: yellow;
        }
    </style>
</head>
<body>
    
    <div class="container">
        <h1>Edit Data Transaksi</h1>
        <form method="POST">
            <input type="hidden" name="id" value="<?= $transaksi['id']; ?>">

            <div class="form-group">
                <label>Pelanggan:</label>
                <select name="client_id" required>
                    <option value="">Pilih Pelanggan</option>
                    <?php foreach ($clients as $client): ?>
                        <option value="<?= $client['id']; ?>" <?= $client['id'] == $transaksi['client_id'] ? 'selected' : '' ?>>
                            <?= $client['nama']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>     
            </div>

            <div class="form-group">
                <label>Produk:</label>
                <select name="product_id" required>
                    <option value="">Pilih Produk</option>
                    <?php foreach ($products as $product): ?>
                        <option value="<?= $product['id']; ?>" <?= $product['id'] == $transaksi['product_id'] ? 'selected' : '' ?>>
                            <?= $product['name']; ?> (Rp<?= number_format($product['price']); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Jumlah:</label>
                <input type="number" name="jumlah" value="<?= $transaksi['jumlah']; ?>" required>
            </div>

            <div class="form-group">
                <label>Tanggal:</label>
                <input type="date" name="tanggal" value="<?= $transaksi['tanggal']; ?>" required>
            </div>

            <button type="submit" class="btn"><i class="fa fa-save"></i> Simpan</button>
            <br>
           </form>
    </div>
</body>
</html>

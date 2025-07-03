<?php
include '../lib/koneksi.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM client WHERE id = :id");
$stmt->execute(['id' => $id]);
$product = $stmt->fetch();

$category_stmt = $conn->prepare("SELECT * FROM tarif");
$category_stmt->execute();
$categories = $category_stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   // $tarif_id = $_POST['tarif_id'];//
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
   // $riwayat = $_POST['riwayat'];
   // $jumlah = $_POST['jumlah'];//
    $telepon = $_POST['telepon'];
    $tanggal = $_POST['tanggal'];


    $stmt = $conn->prepare("UPDATE client SET nama = :nama, alamat = :alamat, telepon = :telepon, tanggal = :tanggal WHERE id = :id");
    $stmt->execute(['nama' => $nama, 'alamat' => $alamat, 'telepon' => $telepon, 'tanggal' => $tanggal, 'id' => $id]);
    echo "<script> window.location.href='petugas.php?page=pelanggan';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #000;
            text-align: center;
            color:rgb(242, 241, 247);
        }
        .container {
            width: 50%;
            margin: auto;
            background: #0d0d0d;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
            margin-top: 50px;
        }
        h1 {
            color:rgb(252, 252, 255);
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
            display: inline-block;
            padding: 10px 20px;
            margin-top: 10px;
            color: white;
            background: #6c5f9e;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        .btn:hover {
            background: #5a4d88;
        }
        .back-link {
            display: inline-block;
            margin-top: 10px;
            color:rgb(234, 233, 238);
            text-decoration: none;
            font-size: 16px;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Data Pelanggan</h1>
        <form method="POST">
            <div class="form-group">
                <label>Nama:</label>
                <input type="text" name="nama" value="<?php echo $product['nama']; ?>" required>
            </div>
            <div class="form-group">
                <label>Alamat:</label>
                <input type="text" name="alamat" value="<?php echo $product['alamat']; ?>" required>
            </div>
           <!-- <div class="form-group">
                <label>Riwayat:</label>
                <input type="text" name="riwayat" value="<?php echo $product['riwayat']; ?>" required>
            </div>-->
           <!-- <div class="form-group">
                <label>Tarif:</label>
                <select name="tarif_id" required>
                    <?php foreach ($categories as $tarif): ?>
                        <option value="<?php echo htmlspecialchars($tarif['id']); ?>">
                            <?php echo htmlspecialchars($tarif['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>-->
        <!--    <div class="form-group">
                <label>Jumlah:</label>
                <input type="number" name="jumlah" value="<?php echo $product['jumlah']; ?>" required>
            </div>-->
            <div class="form-group">
                <label>Telepon:</label>
                <input type="number" name="telepon" value="<?php echo $product['telepon']; ?>" required>
            </div>
            <div class="form-group">
                <label>Tanggal:</label>
                <input type="date" name="tanggal" value="<?php echo $product['tanggal']; ?>" required>
            </div>
            <button type="submit" class="btn"><i class="fa fa-save"></i> Simpan</button>
        </form>
         </div>
</body>
</html>

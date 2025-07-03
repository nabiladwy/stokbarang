<?php
include '../lib/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'] ?? '';
    $alamat = $_POST['alamat'] ?? '';
    $telepon = $_POST['telepon'] ?? '';
    $tanggal = $_POST['tanggal'] ?? '';

    // Validasi semua field tidak kosong
    if ($nama && $alamat && $telepon && $tanggal) {
        $stmt = $conn->prepare("INSERT INTO client (nama, alamat, telepon, tanggal) 
                                VALUES (:nama, :alamat, :telepon, :tanggal)");
        $stmt->execute([
            'nama' => $nama,
            'alamat' => $alamat,
            'telepon' => $telepon,
            'tanggal' => $tanggal
        ]);
        header("Location: pet_pelanggan.php");
        exit;
    } else {
        echo "<script>alert('Semua data harus diisi!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pelanggan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #000;
            color: white;
            text-align: center;
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
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }
        label {
            display: block;
            font-size: 16px;
            margin-bottom: 5px;
        }
        input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #6c5f9e;
            background: #1a1a1a;
            color: white;
        }
        .btn {
            padding: 10px 20px;
            color: white;
            background: #6c5f9e;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn:hover {
            background: #5a4d88;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tambah Data Pelanggan</h1>
        <form method="POST">
            <div class="form-group">
                <label>Nama:</label>
                <input type="text" name="nama" required>
            </div>
            <div class="form-group">
                <label>Alamat:</label>
                <input type="text" name="alamat" required>
            </div>
            <div class="form-group">
                <label>Telepon:</label>
                <input type="text" name="telepon" required>
            </div>
            <div class="form-group">
                <label>Tanggal:</label>
                <input type="date" name="tanggal" required>
            </div>
            <button type="submit" class="btn"><i class="fa fa-save"></i> Simpan</button>
        </form>
    </div>
</body>
</html>

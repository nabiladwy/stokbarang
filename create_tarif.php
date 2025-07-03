<?php
include '../lib/koneksi.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $stmt = $conn->prepare("INSERT INTO tarif (name) VALUES (:name)");
    $stmt->execute(['name' => $name]);
    header("Location: index_tarif.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #000;
            text-align: center;
            color:rgb(245, 244, 248);
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
            color:rgb(253, 253, 255);
        }
        label {
            display: block;
            margin: 10px 0;
            font-size: 18px;
        }
        input[type="text"] {
            width: 80%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #6c5f9e;
            border-radius: 5px;
            background: #1a1a1a;
            color: white;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Tambah</h1>
        <form method="POST">
            <label for="name">Nama:</label>
            <input type="text" id="name" name="name" required>
            <button type="submit" class="btn"><i class="fa fa-save"></i> Simpan</button>
        </form>
       </div>
</body>
</html>

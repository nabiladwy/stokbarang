<?php
include '../lib/koneksi.php';
$stmt = $conn->prepare("SELECT * FROM tarif");
$stmt->execute();
$categories = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarif</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #000;
            text-align: center;
            color: #6c5f9e;
        }
        .container {
            width: 80%;
            margin: auto;
            background: #0d0d0d;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
            margin-top: 50px;
        }
        h1 {
            color:rgb(247, 246, 252);
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 0;
            color: white;
            background: #6c5f9e;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover {
            background: #5a4d88;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #1a1a1a;
        }
        table, th, td {
            border: 1px solid #6c5f9e;
        }
        th, td {
            padding: 10px;
            text-align: center;
            color:rgb(255, 255, 255);
        }
        th {
            background-color: #6c5f9e;
        }
        .action a {
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
        }
        .edit {
            background: #b38600;
        }
        .delete {
            background: #990000;
        }
        .edit:hover {
            background: #e6b800;
        }
        .delete:hover {
            background: #cc0000;
        }
        .back-link {
            display: inline-block;
            margin-top: 10px;
            color:rgb(234, 233, 238);
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
        <h1>Daftar Tarif</h1>
        <a href="create_tarif.php" class="btn"><i class="fa fa-plus"></i> Tambah</a>
        <table>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Aksi</th>
            </tr>
            <?php foreach ($categories as $category): ?>
            <tr>
                <td><?php echo $category['id']; ?></td>
                <td><?php echo $category['name']; ?></td>
                <td class="action">
                    <a href="edit_tarif.php?id=<?php echo $category['id']; ?>" class="edit"><i class="fa fa-edit"></i> Edit</a>
                    <a href="delete_tarif.php?id=<?php echo $category['id']; ?>" class="delete" onclick="return confirm('Apakah Anda yakin ingin menghapus tarif ini?');"><i class="fa fa-trash"></i> Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <a href="pelanggan.php" class="back-link">Kembali</a>
</body>
</html>

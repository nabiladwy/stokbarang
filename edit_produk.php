<?php
include '../lib/koneksi.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM products WHERE id = :id");
$stmt->execute(['id' => $id]);
$product = $stmt->fetch();

$category_stmt = $conn->prepare("SELECT * FROM categories");
$category_stmt->execute();
$categories = $category_stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stok = $_POST['stok'];
    $category_id = $_POST['category_id'];

    $stmt = $conn->prepare("UPDATE products SET name = :name, price = :price, stok = :stok, category_id = :category_id WHERE id = :id");
    $stmt->execute(['name' => $name, 'price' => $price, 'stok' => $stok, 'category_id' => $category_id, 'id' => $id]);
    echo "<script> window.location.href='admin.php?page=produk';</script>";
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
            color:rgb(245, 244, 247);
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
            color:rgb(249, 248, 252);
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
        <h1>Edit Produk</h1>
        <form method="POST">
            <div class="form-group">
                <label>Nama:</label>
                <input type="text" name="name" value="<?php echo $product['name']; ?>" required>
            </div>
            <div class="form-group">
                <label>Harga:</label>
                <input type="number" name="price" value="<?php echo $product['price']; ?>" required>
            </div>
            <div class="form-group">
                <label>Stok:</label>
                <input type="number" name="stok" value="<?php echo $product['stok']; ?>" required>
            </div>
            <div class="form-group">
                <label>Kategori:</label>
                <select name="category_id" required>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>" <?php if ($category['id'] == $product['category_id']) echo 'selected'; ?>>
                            <?php echo $category['name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn"><i class="fa fa-save"></i> Simpan</button>
        </form>
         </div>
</body>
</html>

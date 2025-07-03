<?php
include '../lib/koneksi.php';

$stmt = $conn->prepare("SELECT * FROM categories");
$stmt->execute();
$categories = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stok = $_POST['stok'];
    $category_id = $_POST['category_id'];

    $stmt = $conn->prepare("INSERT INTO products (name, price, category_id, stok) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $price, $category_id, $stok]);

    echo "<script> window.location.href='admin.php?page=produk';</script>";
}
?> 


    <div class="kontainer">
       <center> <b>Tambah Produk</b></center><br>
        <form method="POST">
            <div class="form-group">
                <label>Nama:</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Harga:</label>
                <input type="number" name="price" required>
            </div>
            <div class="form-group">
                <label>Stok:</label>
                <input type="number"  name="stok" required>
            </div>
            <div class="form-group">
                <label>Kategori:</label>
                <select name="category_id" required>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>">
                            <?php echo $category['name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn"><i class="fa fa-save"></i> Simpan</button>
        </form>
         </div>

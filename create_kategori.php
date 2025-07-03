<?php
include '../lib/koneksi.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (:name)");
    $stmt->execute(['name' => $name]);
    echo "<script> window.location.href='admin.php?page=kategori';</script>";
}
?>
<center>
    <div class="kontainer">
        <b>Tambah Kategori</b><br>
        <form method="POST">
            <label for="name">Nama:</label>
            <input type="text" id="name" name="name" required><br>
            <button type="submit" class="btn"><i class="fa fa-save"></i> Simpan</button>
        </form>
        </div>

        </center>
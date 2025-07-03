<?php
include '../lib/koneksi.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (:name)");
    $stmt->execute(['name' => $name]);
    echo "<script> window.location.href='petugas.php?page=kategori';</script>";
}
?>

    <div class="kontainer">
        <h1>Tambah Kategori</h1>
        <form method="POST">
            <label for="name">Nama:</label>
            <input type="text" id="name" name="name" required>
            <button type="submit" class="btn"><i class="fa fa-save"></i> Simpan</button>
        </form>
        </div>
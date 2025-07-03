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
        echo "<script> window.location.href='petugas.php?page=pelanggan';</script>";
        exit;
    } else {
        echo "<script>alert('Semua data harus diisi!');</script>";
    }
}
?>
     
    <div class="kontainer">
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
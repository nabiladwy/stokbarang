<?php
include '../lib/koneksi.php';

$id = $_GET['id'];

try {
    $stmt = $conn->prepare("DELETE FROM client WHERE id = :id");
    $stmt->execute(['id' => $id]);
    echo "<script> window.location.href='admin.php?page=pelanggan';</script>";
} catch (PDOException $e) {
    // Cek jika error karena foreign key constraint
    if ($e->getCode() == '23000') {
        echo "<script> window.location.href='admin.php?page=pelanggan';</script>";
    } else {
        // Error lain, bisa tampilkan pesan atau log error
        echo "<script> window.location.href='admin.php?page=pelanggan';</script>";
    }
}
?>
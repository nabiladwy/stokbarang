<?php
include '../lib/koneksi.php';

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM transaksi WHERE id = :id");
$stmt->execute(['id' => $id]);
echo "<script> window.location.href='admin.php?page=transaksi';</script>";
?>
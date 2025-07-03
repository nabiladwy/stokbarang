<?php
include '../lib/koneksi.php';

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM user WHERE id = :id");
$stmt->execute(['id' => $id]);
header("Location: admin.php?page=user");
?>
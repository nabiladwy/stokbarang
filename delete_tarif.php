<?php
include '../lib/koneksi.php';

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM tarif WHERE id = :id");
$stmt->execute(['id' => $id]);
header("Location: index_tarif.php");
?>
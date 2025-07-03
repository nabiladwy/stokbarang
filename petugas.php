<?php
include '../lib/koneksi.php';
session_start();
date_default_timezone_set('Asia/Jakarta');

if (empty($_SESSION['email']) || $_SESSION['level'] !== 'petugas') {
    header("Location: ../login.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Petugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        display: flex;
        height: 100vh;
        background-color: #313131;
        color: #fff;
        overflow: hidden;
    }
    .badan {
        
    }

    .sidebar {
        width: 250px;
        height: 100vh;
        background-color: #343a40;
        color: white;
        padding: 20px;
        position: fixed;
        box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.3);
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: transparent transparent;
    }

    .sidebar::-webkit-scrollbar {
        width: 0px;
    }

    .nav-item a {
        display: block;
        padding: 10px;
        margin: 5px 0;
        background: linear-gradient(145deg, #3d444b, #2e3237);
        border-radius: 8px;
        text-align: center;
        box-shadow: 3px 3px 6px rgba(0, 0, 0, 0.4), -3px -3px 6px rgba(255, 255, 255, 0.1);
        transition: all 0.2s ease-in-out;
        text-decoration: none;
        color: white;
    }

    .nav-item a:hover {
        background: linear-gradient(145deg, #2e3237, #3d444b);
        box-shadow: inset 3px 3px 6px rgba(0, 0, 0, 0.4), inset -3px -3px 6px rgba(255, 255, 255, 0.1);
    }

    .content {
        margin-left: 250px;
        padding: 30px;
        width: calc(100% - 250px);
        overflow-y: auto;
    }

    h1, h2 {
        font-size: 20px;
        text-align: center;
        color: #f9f9f9;
    }

    b {
        font-size: 20px;
        text-align: center;
    }
    .main-wrapper {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        padding: 40px;
        justify-content: center;
    }

    .form-container, .table-container {
        background: #1f1f1f;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 0 10px rgba(0,0,0,0.5);
    }

    .form-container {
        flex: 1 1 350px;
        max-width: 400px;
    }

    .table-container {
        flex: 2 1 600px;
        overflow-x: auto;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    label {
        font-size: 16px;
        color: white;
        margin-bottom: 5px;
    }

    input, select, input[type="number"] {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #6c5f9e;
        background: #1a1a1a;
        color: white;
    }

    .btn {
        padding: 10px 20px;
        color: white;
        background: #6c5f9e;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        text-decoration: none;
        text-align: center;
        transition: background 0.3s;
    }

    .btn:hover {
        background: #5a4d88;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        font-size: 14px;
    }

    th, td {
        padding: 12px;
        border: 1px solid #444;
        text-align: center;
    }

    th {
        background-color: #292929;
        color: white;
    }

    td {
        background-color: #1f1f1f;
    }

    .action a {
        padding: 6px 10px;
        margin-right: 5px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 13px;
        color: white;
    }

    .edit {
        background-color: #b38600;
    }

    .delete {
        background-color: #990000;
    }

    .edit:hover {
        background-color: #e6b800;
    }

    .delete:hover {
        background-color: #cc0000;
    }

    .back-link {
        display: inline-block;
        margin-top: 30px;
        color: #ddd;
        text-decoration: none;
        font-size: 16px;
    }

    .back-link:hover {
        color: yellow;
    }

    @media (max-width: 900px) {
        .main-wrapper {
            flex-direction: column;
            padding: 20px;
        }
    }

    .kontainer {
        max-width: 600px;
        margin: 50px auto;
        padding: 30px 40px;
        border-radius: 10px;
        background-color: #252525;
    }

    h1 {
        text-align: center;
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
    }

    .form-group input[type="text"],
    .form-group input[type="date"] {
        width: 100%;
        padding: 10px;
        border-radius: 6px;
        border: 1px solid #ccc;
        font-size: 14px;
    }
    

    .edit {
        background-color: #b38600;
    }

    .edit:hover {
        background-color: #e6b800;   
    }
    .action a {
        padding: 6px 10px;
        margin-right: 5px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 13px;
        color: white;
    }

</style>
</head>
<body class="badan">
    <div class="sidebar">
        <center><img src="../asset/img/logoo.png" style="width:120px;"></center>
        <ul class="nav flex-column">
            <li class="p-2 mt-3 nav-item"><a class="nav-link text-white" href="petugas.php"><i class="fa-solid fa-house" style="margin-right: 10px;"></i>Home</a></li>
            <li class="p-2 mt-3 nav-item"><a class="nav-link text-white" href="petugas.php?page=produk"><i class="fa-solid fa-table" style="margin-right: 10px;"></i>Produk</a></li>
            <li class="p-2 mt-3 nav-item"><a class="nav-link text-white" href="petugas.php?page=transaksi"><i class="fa-solid fa-cash-register" style="margin-right: 10px;"></i>Transaksi</a></li>
            <li class="p-2 mt-3 nav-item"><a class="nav-link text-white" href="petugas.php?page=pelanggan"><i class="fa-solid fa-users" style="margin-right: 10px;"></i>Pelanggan</a></li>
            <li class="p-2 nav-item"><a class="nav-link text-white" href="keluar.php"><i class="fa-solid fa-right-from-bracket" style="margin-right: 10px;"></i>LogOut</a></li>
        </ul>
    </div>

    <div class="content">
        <?php
        $page = $_GET['page'] ?? null;
        switch ($page) {
            case 'produk':
                include "pet_produk.php";
                break;
            case 'tambah_produk':
                    include "tambah_produk.php";
                    break;
            case 'laporan':
                include "laporan.php";
                break;
            case 'transaksi':
                include "pet_transaksi.php";
                break;
            case 'pelanggan':
                include "pet_pelanggan.php";
                break;
            case 'tambah_pel':
                    include "tambah_pel.php";
                    break;
            case 'kategori':
                    include "pet_kategori.php";
                    break;
            case 'tambah_kategori':
                        include "tambah_kategori.php";
                        break;
                default:
                echo '<div class="container-fluid p-5 text-center rounded-4 shadow" style="background-color:rgb(59, 59, 59); margin-top: 210px; width:">
                            <h1 class="text-white mb-3">📦 Aplikasi Stok Barang</h1>
                            <p class="text-light h5">Selamat datang di sistem manajemen stok</p>
                            <p class="text-white-50">Gunakan menu navigasi untuk mulai mengelola data</p>
                        </div>';
                break;
            
        }
        ?>
    </div>

   
</body>
</html>

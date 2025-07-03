<?php
session_start();
date_default_timezone_set('Asia/Jakarta');
include "lib/koneksi.php";

if (!isset($_SESSION['email'])) {
    include "login.php";
} else {
    $sqlUser = $conn->prepare("SELECT * FROM user WHERE email='$_SESSION[email]'");
    $sqlUser->execute();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            display: flex;
            height: 100vh;
            overflow: hidden;
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
        }
        .nav-item a:hover {
            background: linear-gradient(145deg, #2e3237, #3d444b);
            box-shadow: inset 3px 3px 6px rgba(0, 0, 0, 0.4), inset -3px -3px 6px rgba(255, 255, 255, 0.1);
        }
        .content {
            margin-left: 260px;
            padding: 20px;
            width: 100%;
        }
    </style>
</head>
<body>

<?php 
 $page = $_GET['page'] ?? null;
 if (isset($page)) {
  if ($page=='keluar'){
    include"modul/keluar.php";
  }
if ($page=='index_produk'){
  include"modul/index_produk.php";
}
if ($page=='edit_produk'){
  include"modul/edit_produk.php";
}
if ($page=='create_produk'){
  include"modul/create_produk.php";
}
if ($page=='user'){
  include"modul/user.php";
}
if ($page=='edit_user'){
  include"modul/edit_user.php";
}
if ($page=='delete_user'){
  include"modul/delete_user.php";
}
if ($page=='client'){
  include"modul/client.php";
}
if ($page=='editclient'){
  include"modul/edituser.php";
}
if ($page=='delclient'){
  include"modul/deluser.php";
}
if ($page=='payment'){
  include"modul/payment.php";
}
if ($page=='editpay'){
  include"modul/editpay.php";
}


 }else{
  include"login.php";
 }
?>


</body>
</html>
<?php 
}
?>

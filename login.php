<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


$host = "localhost";
$dbname = "kasir"; // ganti dengan nama database kamu
$username = "root"; // sesuaikan
$password = "nabila123"; // sesuaikan

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    try {
        $query = "SELECT * FROM user WHERE email = :email";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if ($pass == $user['password']) {
                $_SESSION['email'] = $user['email'];
                $_SESSION['level'] = $user['level'];

                if ($user['level'] == 'admin') {
                    header("Location: modul/admin.php");
                } elseif ($user['level'] == 'petugas') {
                    header("Location: modul/petugas.php");
                } else {
                    header("Location: index.php");
                }
                exit();
            } else {
                $error_message = "Password salah";
            }
        } else {
            $error_message = "Email tidak ditemukan";
        }
    } catch (PDOException $e) {
        $error_message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="card">
        <div class="card-header">
            <h2>Login</h2>
        </div>
        <div class="card-body p-4">
            <form method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger mt-3" role="alert">
                    <?= $error_message ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

<style>
    body, html {
        height: 100%;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #eef2f5;
    }

    .card {
        width: 400px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        border: none;
    }

    .card-header {
        background-color: #0056b3;
        color: white;
        font-weight: bold;
        text-align: center;
        padding: 1rem;
    }

    .form-control:focus {
        border-color: #0056b3;
        box-shadow: none;
    }

    .btn-primary {
        background-color: #0056b3;
        border: none;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #003d80;
    }
</style>

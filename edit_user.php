<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .custom-purple { color:rgb(243, 242, 247); }
        .bg-custom-purple { background-color: #6c5f9e; }
        .border-custom-purple { border-color: #6c5f9e; }
    </style>
</head>
<body class="bg-black text-white">
    <div class="container mx-auto p-5">
        <div class="max-w-lg mx-auto bg-gray-900 p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-semibold custom-purple mb-4">Edit User</h2>

            <?php
            // Koneksi ke database
            include '../lib/koneksi.php';

            // Ambil ID dari URL atau pakai default saat develop
            $id = isset($_GET['id']) && is_numeric($_GET['id']) ? (int) $_GET['id'] : 1;

            // Ambil data user berdasarkan ID
            $stmt = $conn->prepare("SELECT * FROM user WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $outCek = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$outCek) {
                header("Location: admin.php?page=user");
                exit;
            }
            ?>

            <form method="POST">
                <div class="mb-4">
                    <label class="block custom-purple">Email</label>
                    <input type="text" name="email" class="w-full p-2 mt-1 bg-gray-800 text-white rounded-lg border border-custom-purple focus:ring focus:ring-custom-purple" value="<?php echo htmlspecialchars($outCek['email']); ?>" required>
                </div>
                <div class="mb-4">
                    <label class="block custom-purple">Password</label>
                    <input type="text" name="password" class="w-full p-2 mt-1 bg-gray-800 text-white rounded-lg border border-custom-purple focus:ring focus:ring-custom-purple" value="<?php echo htmlspecialchars($outCek['password']); ?>" required>
                </div>
                <div class="mb-4">
                    <label class="block custom-purple">Level</label>
                    <select name="level" class="w-full p-2 mt-1 bg-gray-800 text-white rounded-lg border border-custom-purple focus:ring focus:ring-custom-purple">
                        <option value="Petugas" <?php echo ($outCek['level'] == 'Petugas') ? 'selected' : ''; ?>>Petugas</option>
                        <option value="Admin" <?php echo ($outCek['level'] == 'Admin') ? 'selected' : ''; ?>>Admin</option>
                    </select>
                </div>
                <button type="submit" name="btn" class="w-full bg-custom-purple hover:bg-opacity-80 text-white font-bold py-2 px-4 rounded">Update Data</button>
               </form>

            <?php
            if (isset($_POST['btn'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];
                $level = $_POST['level'];

                $stmt = $conn->prepare("UPDATE user SET email = :email, password = :password, level = :level WHERE id = :id");
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':level', $level);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    header("Location: admin.php?page=user");
                    exit;
                } else {
                    echo "<script>alert('Gagal mengupdate data!');</script>";
                }
            }
            ?>
        </div>
    </div>
</body>
</html>

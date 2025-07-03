<?php
include '../lib/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $level = $_POST['level'];

    try {
        $stmt = $conn->prepare("INSERT INTO user (email, password, level) VALUES (:email, :pass, :level)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pass', $pass);
        $stmt->bindParam(':level', $level);
        $stmt->execute();

        // Boleh kasih notifikasi atau redirect
        echo "<script> window.location.href='admin.php?page=user';</script>";
    } catch (PDOException $e) {
        echo "Gagal menambahkan user: " . $e->getMessage();
    }
}
?>

    <div class="flex flex-wrap gap-6 justify-center">
  <!-- Form Tambah User -->
  <div class="bg-gray-900 p-6 rounded-xl shadow w-full md:w-[350px]">
    <h2 class="text-xl font-semibold text-white mb-4">Tambah User</h2>
    <form action="" method="post" class="space-y-4">
      <div>
        <label for="email" class="block text-white mb-1">Email</label>
        <input type="text" name="email" id="email" class="w-full p-2 rounded bg-gray-800 text-white" placeholder="Masukkan Email">
      </div>
      <div>
        <label for="password" class="block text-white mb-1">Password</label>
        <input type="password" name="password" id="password" class="w-full p-2 rounded bg-gray-800 text-white" placeholder="Masukkan Password">
      </div>
      <div>
        <label for="level" class="block text-white mb-1">Level</label>
        <select name="level" id="level" class="w-full p-2 rounded bg-gray-800 text-white">
          <option value="petugas">Petugas</option>
          <option value="admin">Admin</option>
        </select>
      </div>
      <div class="flex justify-between">
        <button type="submit" class="bg-custom-purple hover:bg-purple-700 text-white py-2 px-4 rounded">Input Data</button>
      </div>
    </form>
  </div>

  <!-- Tabel Daftar User -->
  <div class="bg-gray-900 p-6 rounded-xl shadow overflow-auto w-full md:flex-1">
    <h2 class="text-xl font-semibold text-white mb-4">Daftar User</h2>
    <table class="table-auto w-full text-white text-sm border-collapse">
      <thead>
        <tr class="bg-custom-purple">
          <th class="p-3 text-left">No</th>
          <th class="p-3 text-left">Email</th>
          <th class="p-3 text-left">Password</th>
          <th class="p-3 text-left">Level</th>
          <th class="p-3 text-left">Aksi</th>
        </tr>
      </thead>
      <tbody>
    <?php
    require_once "../lib/koneksi.php";
    $no = 1;
    $sqlUser = $conn->query("SELECT * FROM user");

    while ($dataResl = $sqlUser->fetch(PDO::FETCH_ASSOC)) :
    ?>
        <tr>
            <td class="py-2 px-4 border border-gray-700"><?= $no++ ?></td>
            <td class="py-2 px-4 border border-gray-700"><?= htmlspecialchars($dataResl['email']) ?></td>
            <td class="py-2 px-4 border border-gray-700"><?= htmlspecialchars($dataResl['password']) ?></td>
            <td class="py-2 px-4 border border-gray-700"><?= htmlspecialchars($dataResl['level']) ?></td>
            <td class="py-2 px-4 border border-gray-700 space-x-2">
                <a href="edit_user.php?id=<?= $dataResl['id'] ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">Edit</a>
                <a href="delete_user.php?id=<?= $dataResl['id'] ?>" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded" onclick="return confirm('Yakin ingin menghapus user ini?')">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</tbody>

    </table>
  </div>
</div>

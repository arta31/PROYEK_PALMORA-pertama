<?php
session_start();
require '../middleware/auth.php';
include '../header.php';

require '../../Models/UserModel.php';
$userModel = new UserModel($conn);

$users = $userModel->getAllUsers();
?>

<div class="md:ml-64 p-6">
  <h2 class="text-2xl font-semibold mb-6">Kelola Pengguna</h2>

  <?php if (isset($_SESSION['success'])): ?>
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
  <?php endif; ?>

  <div class="bg-white shadow rounded overflow-hidden">
    <table class="w-full table-auto">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-4 py-2">#</th>
          <th class="px-4 py-2">Nama</th>
          <th class="px-4 py-2">Email</th>
          <th class="px-4 py-2">Role</th>
          <th class="px-4 py-2">Status</th>
          <th class="px-4 py-2">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($users)): $no = 1; foreach ($users as $u): ?>
          <tr>
            <td class="border px-4 py-2 text-center"><?= $no++ ?></td>
            <td class="border px-4 py-2"><?= htmlspecialchars($u['name']) ?></td>
            <td class="border px-4 py-2"><?= htmlspecialchars($u['email']) ?></td>
            <td class="border px-4 py-2"><?= ucfirst(htmlspecialchars($u['role'])) ?></td>
            <td class="border px-4 py-2">
              <span class="inline-block px-2 py-1 rounded text-white text-xs 
                <?= $u['is_active'] ? 'bg-green-500' : 'bg-red-500' ?>">
                <?= $u['is_active'] ? 'Aktif' : 'Tidak Aktif' ?>
              </span>
            </td>
            <td class="border px-4 py-2 text-center space-x-2">
              <a href="../../Controllers/UserController.php?action=toggle&id=<?= $u['id'] ?>" class="text-yellow-600 hover:underline">Ubah Status</a>
              <a href="../../Controllers/UserController.php?action=delete&id=<?= $u['id'] ?>" onclick="return confirm('Yakin ingin menghapus?')" class="text-red-600 hover:underline">Hapus</a>
            </td>
          </tr>
        <?php endforeach; else: ?>
          <tr>
            <td colspan="6" class="text-center py-4">Belum ada pengguna.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include '../footer.php'; ?>
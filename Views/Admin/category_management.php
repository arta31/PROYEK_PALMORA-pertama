<?php
session_start();
require '../middleware/auth.php';
include '../header.php';

require '../../Models/CategoryModel.php';
$categoryModel = new CategoryModel($conn);

$categories = $categoryModel->getAllCategories();
?>

<div class="md:ml-64 p-6">
  <h2 class="text-2xl font-semibold mb-6">Kelola Kategori Produk</h2>

  <?php if (isset($_SESSION['success'])): ?>
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
  <?php endif; ?>
  <?php if (isset($_SESSION['error'])): ?>
    <div class="bg-red-100 text-red-700 p-3 rounded mb-4"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
  <?php endif; ?>

  <!-- Form Tambah Kategori -->
  <form action="../../Controllers/CategoryController.php?action=add" method="POST" class="mb-8 bg-white p-6 rounded shadow max-w-md mx-auto space-y-4">
    <h3 class="font-bold text-lg">Tambah Kategori Baru</h3>
    <div>
      <label for="name" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
      <input type="text" name="name" id="name" required class="mt-1 block w-full border border-gray-300 rounded-md p-2">
    </div>
    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded">Simpan</button>
  </form>

  <!-- Daftar Kategori -->
  <div class="bg-white shadow rounded overflow-hidden">
    <table class="w-full table-auto">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-4 py-2">#</th>
          <th class="px-4 py-2">Nama Kategori</th>
          <th class="px-4 py-2">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($categories)): ?>
          <tr>
            <td colspan="3" class="text-center py-4">Belum ada kategori.</td>
          </tr>
        <?php else: $no = 1; foreach ($categories as $cat): ?>
          <tr>
            <td class="border px-4 py-2 text-center"><?= $no++ ?></td>
            <td class="border px-4 py-2"><?= htmlspecialchars(ucfirst($cat['name'])) ?></td>
            <td class="border px-4 py-2 text-center space-x-2">
              <button onclick="document.getElementById('editModal<?= $cat['id'] ?>').classList.remove('hidden')" class="text-blue-600 hover:underline">Edit</button>
              <a href="../../Controllers/CategoryController.php?action=delete&id=<?= $cat['id'] ?>" onclick="return confirm('Yakin ingin menghapus?')" class="text-red-600 hover:underline">Hapus</a>
            </td>
          </tr>

          <!-- Modal Edit -->
          <div id="editModal<?= $cat['id'] ?>" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center p-4 z-50">
            <div class="bg-white rounded shadow-lg w-full max-w-md">
              <div class="p-4 border-b">
                <h3 class="text-lg font-semibold">Edit Kategori</h3>
              </div>
              <form action="../../Controllers/CategoryController.php?action=update" method="POST" class="p-4 space-y-4">
                <input type="hidden" name="id" value="<?= $cat['id'] ?>">
                <div>
                  <label for="name_<?= $cat['id'] ?>" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                  <input type="text" name="name" id="name_<?= $cat['id'] ?>" value="<?= htmlspecialchars($cat['name']) ?>" required class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                </div>
                <div class="flex justify-end space-x-2">
                  <button type="button" onclick="document.getElementById('editModal<?= $cat['id'] ?>').classList.add('hidden')" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">Batal</button>
                  <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include '../footer.php'; ?>
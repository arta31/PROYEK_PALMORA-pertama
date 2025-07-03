<?php 
session_start(); 
require '../middleware/auth.php';
include '../header.php'; 

require '../../Models/CategoryModel.php';
$categoryModel = new CategoryModel($conn);
$categories = $categoryModel->getAllCategories();
?>

<div class="md:ml-64 p-6">
  <h2 class="text-2xl font-semibold mb-6">Tambah Produk Baru</h2>

  <?php if (isset($_SESSION['error'])): ?>
    <div class="bg-red-100 text-red-700 p-3 rounded mb-4"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
  <?php endif; ?>

  <form action="../../Controllers/ProductController.php?action=add" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow max-w-lg mx-auto space-y-4">
    <div>
      <label for="name" class="block text-sm font-medium text-gray-700">Nama Produk</label>
      <input type="text" name="name" id="name" required class="mt-1 block w-full border border-gray-300 rounded-md p-2">
    </div>
    <div>
      <label for="price" class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
      <input type="number" name="price" id="price" required class="mt-1 block w-full border border-gray-300 rounded-md p-2">
    </div>
    <div>
      <label for="type" class="block text-sm font-medium text-gray-700">Kategori Produk</label>
      <select name="type" id="type" required class="mt-1 block w-full border border-gray-300 rounded-md p-2">
        <option value="">-- Pilih Kategori --</option>
        <?php foreach ($categories as $cat): ?>
          <option value="<?= htmlspecialchars($cat['name']) ?>"><?= htmlspecialchars(ucfirst($cat['name'])) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div>
      <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Produk</label>
      <textarea name="description" id="description" rows="4" required class="mt-1 block w-full border border-gray-300 rounded-md p-2"></textarea>
    </div>
    <div>
      <label for="image" class="block text-sm font-medium text-gray-700">Gambar Produk</label>
      <input type="file" name="image" id="image" accept="image/*" required class="mt-1 block w-full border border-gray-300 rounded-md p-2">
      <small class="text-gray-500">Format: JPG, JPEG, PNG | Maks: 2MB</small>
    </div>

    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded">Simpan Produk</button>
  </form>
</div>

<?php include '../footer.php'; ?>
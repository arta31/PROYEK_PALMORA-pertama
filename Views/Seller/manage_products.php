<?php
session_start();
require '../middleware/auth.php';
include '../header.php';

require '../../Models/ProductModel.php';
$productModel = new ProductModel($conn);

$seller_id = $_SESSION['user']['id'];
$stmt = $conn->prepare("SELECT * FROM products WHERE seller_id = ?");
$stmt->bind_param("i", $seller_id);
$stmt->execute();
$result = $stmt->get_result();
$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}
?>

<div class="md:ml-64 p-6">
  <h2 class="text-2xl font-semibold mb-6">Kelola Produk Saya</h2>

  <?php if (isset($_SESSION['success'])): ?>
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
  <?php endif; ?>

  <div class="flex justify-between items-center mb-4">
    <h3 class="text-lg font-medium">Daftar Produk</h3>
    <a href="add_product.php" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">+ Tambah Produk</a>
  </div>

  <div class="bg-white shadow rounded overflow-hidden">
    <table class="w-full table-auto">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-4 py-2">No.</th>
          <th class="px-4 py-2">Gambar</th>
          <th class="px-4 py-2">Nama Produk</th>
          <th class="px-4 py-2">Harga</th>
          <th class="px-4 py-2">Kategori</th>
          <th class="px-4 py-2">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($products)): ?>
          <tr>
            <td colspan="6" class="text-center py-4">Belum ada produk.</td>
          </tr>
        <?php else: $no = 1; foreach ($products as $p): ?>
          <tr>
            <td class="border px-4 py-2 text-center"><?= $no++ ?></td>
            <td class="border px-4 py-2"><img src="<?= $p['image'] ?>" alt="<?= $p['name'] ?>" class="w-16 h-16 object-cover"></td>
            <td class="border px-4 py-2"><?= htmlspecialchars($p['name']) ?></td>
            <td class="border px-4 py-2">Rp <?= number_format($p['price'], 0, ',', '.') ?></td>
            <td class="border px-4 py-2"><?= ucfirst($p['type']) ?></td>
            <td class="border px-4 py-2 text-center">
              <a href="../../Controllers/ProductController.php?action=delete&id=<?= $p['id'] ?>" onclick="return confirm('Yakin ingin menghapus?')" class="text-red-500 hover:underline">Hapus</a>
            </td>
          </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include '../footer.php'; ?>
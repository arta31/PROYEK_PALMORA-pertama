<?php 
session_start(); 
require '../middleware/auth.php'; 
include '../header.php'; 

require '../../Models/CartModel.php';
require '../../Models/ProductModel.php';
$cartModel = new CartModel($conn);
$productModel = new ProductModel($conn);

$user_id = $_SESSION['user']['id'];
$cartItems = $cartModel->getCartItems($user_id);
$products = $productModel->getAllProducts();
?>

<div class="md:ml-64 p-6">
  <h2 class="text-2xl font-semibold mb-6">Selamat Datang, <?= $_SESSION['user']['name'] ?></h2>
  <p class="mb-6">Jelajahi produk turunan kelapa sawit terbaik kami:</p>

  <!-- Form Pencarian -->
  <form action="../Product/index.php" method="GET" class="max-w-md mx-auto mb-6">
    <div class="flex">
      <input type="text" name="q" placeholder="Cari produk..." class="w-full px-4 py-2 border border-gray-300 rounded-l focus:outline-none">
      <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-r">Cari</button>
    </div>
  </form>

  <!-- Filter Kategori -->
  <div class="flex justify-center space-x-4 mb-6">
    <a href="../Product/category.php?category=minyak" class="px-4 py-2 bg-green-100 text-green-800 rounded hover:bg-green-200">Minyak Sawit</a>
    <a href="../Product/category.php?category=cosmetic" class="px-4 py-2 bg-purple-100 text-purple-800 rounded hover:bg-purple-200">Kosmetik</a>
    <a href="../Product/category.php?category=sabun" class="px-4 py-2 bg-blue-100 text-blue-800 rounded hover:bg-blue-200">Sabun</a>
  </div>

  <!-- Daftar Produk -->
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
    <?php if (!empty($products)): ?>
      <?php foreach ($products as $p): ?>
        <div class="border rounded p-4 bg-white shadow-sm">
          <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" class="mx-auto w-full h-32 object-cover mb-2">
          <h3 class="font-medium"><?= htmlspecialchars($p['name']) ?></h3>
          <p class="text-sm text-gray-600">Rp <?= number_format($p['price'], 0, ',', '.') ?></p>
          <form action="../../Controllers/CartController.php?action=add" method="POST">
            <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
            <input type="number" name="quantity" value="1" min="1" class="mt-2 w-16 text-center border rounded">
            <button type="submit" class="mt-2 w-full bg-green-600 text-white py-1 rounded hover:bg-green-700">Tambah ke Keranjang</button>
          </form>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="col-span-full text-center text-gray-500">Belum ada produk tersedia.</p>
    <?php endif; ?>
  </div>
</div>

<?php include '../footer.php'; ?>
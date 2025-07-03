<?php if (!isset($_SESSION['user'])) return; ?>
<aside class="w-64 bg-white shadow-md h-full min-h-screen fixed top-0 left-0 p-4 hidden md:block">
  <nav class="space-y-2 mt-6">
    <?php $role = $_SESSION['user']['role']; ?>
    
    <?php if ($role === 'admin'): ?>
      <a href="../Admin/dashboard.php" class="block px-4 py-2 rounded hover:bg-indigo-100">Dashboard Admin</a>
      <a href="../Admin/user_management.php" class="block px-4 py-2 rounded hover:bg-indigo-100">Kelola Pengguna</a>
      <a href="../Admin/product_management.php" class="block px-4 py-2 rounded hover:bg-indigo-100">Kelola Produk</a>
      <a href="../Admin/transaction.php" class="block px-4 py-2 rounded hover:bg-indigo-100">Transaksi</a>
      <a href="../Admin/category_management.php" class="block px-4 py-2 rounded hover:bg-indigo-100">Kelola Kategori</a>

    <?php elseif ($role === 'seller'): ?>
      <a href="../Seller/dashboard.php" class="block px-4 py-2 rounded hover:bg-indigo-100">Dashboard Seller</a>
      <a href="../Seller/manage_products.php" class="block px-4 py-2 rounded hover:bg-indigo-100">Produk Saya</a>
      <a href="../Seller/order_status.php" class="block px-4 py-2 rounded hover:bg-indigo-100">Status Pesanan</a>
      <a href="../Seller/order_notifications.php" class="block px-4 py-2 rounded hover:bg-indigo-100">Notifikasi Pesanan</a>

    <?php else: ?>
      <a href="../Buyer/dashboard.php" class="block px-4 py-2 rounded hover:bg-indigo-100">Dashboard Pembeli</a>
      <a href="../Cart/index.php" class="block px-4 py-2 rounded hover:bg-indigo-100">Keranjang</a>
      <a href="../Buyer/orders.php" class="block px-4 py-2 rounded hover:bg-indigo-100">Riwayat Belanja</a>
    <?php endif; ?>

    <a href="../Controllers/AuthController.php?action=logout" class="mt-4 block px-4 py-2 rounded bg-red-500 text-white hover:bg-red-600">Logout</a>
  </nav>
</aside>
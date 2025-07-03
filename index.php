<?php
session_start();
include 'Views/header.php';
include 'Views/navBar.php'; // Sidebar role-based
?>

<div class="md:ml-64 p-6">
  <div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-green-700 mb-6">Selamat Datang di Palmora</h1>
    <p class="mb-6 text-lg">Toko online produk turunan kelapa sawit terbaik.</p>

    <!-- Banner Promo -->
    <div class="bg-indigo-100 p-6 rounded-lg mb-8 flex items-center justify-between flex-wrap">
      <div>
        <h2 class="text-xl font-semibold text-indigo-800">Diskon hingga 20% untuk pembelian pertama!</h2>
        <p class="text-sm text-indigo-600 mt-2">Cepat! Hanya berlaku sampai 30 April 2025</p>
      </div>
      <a href="Views/Cart/index.php" class="mt-4 md:mt-0 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded shadow">Lihat Keranjang</a>
    </div>

    <!-- Produk Terpopuler -->
    <h2 class="text-2xl font-semibold mb-4">Produk Kami</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-10">
      <!-- Contoh produk statis -->
      <div class="border rounded p-4 bg-white shadow-md">
        <img src="https://via.placeholder.com/300x200 " alt="Minyak Sawit" class="w-full h-40 object-cover mb-4 rounded">
        <h3 class="font-medium text-lg">Minyak Sawit Murni</h3>
        <p class="text-sm text-gray-600">Rp 25.000</p>
        <button class="mt-4 w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded">Tambah ke Keranjang</button>
      </div>

      <div class="border rounded p-4 bg-white shadow-md">
        <img src="https://via.placeholder.com/300x200 " alt="Sabun Sawit" class="w-full h-40 object-cover mb-4 rounded">
        <h3 class="font-medium text-lg">Sabun Mandi Sawit</h3>
        <p class="text-sm text-gray-600">Rp 15.000</p>
        <button class="mt-4 w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded">Tambah ke Keranjang</button>
      </div>

      <div class="border rounded p-4 bg-white shadow-md">
        <img src="https://via.placeholder.com/300x200 " alt="Kosmetik Sawit" class="w-full h-40 object-cover mb-4 rounded">
        <h3 class="font-medium text-lg">Krim Wajah Sawit</h3>
        <p class="text-sm text-gray-600">Rp 45.000</p>
        <button class="mt-4 w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded">Tambah ke Keranjang</button>
      </div>
    </div>

    <!-- Cari & Filter -->
    <div class="bg-white p-6 rounded-lg shadow mb-10">
      <h2 class="text-xl font-semibold mb-4">Cari Produk</h2>
      <form action="Views/Product/index.php" method="GET" class="flex mb-4">
        <input type="text" name="q" placeholder="Cari produk..." class="w-full px-4 py-2 border border-gray-300 rounded-l focus:outline-none">
        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-r">Cari</button>
      </form>

      <div class="flex space-x-4">
        <a href="Views/Product/category.php?category=minyak" class="bg-yellow-100 hover:bg-yellow-200 text-yellow-800 px-4 py-2 rounded">Minyak Sawit</a>
        <a href="Views/Product/category.php?category=cosmetic" class="bg-purple-100 hover:bg-purple-200 text-purple-800 px-4 py-2 rounded">Kosmetik</a>
        <a href="Views/Product/category.php?category=sabun" class="bg-blue-100 hover:bg-blue-200 text-blue-800 px-4 py-2 rounded">Sabun</a>
      </div>
    </div>

    <!-- Footer -->
    <div class="text-center text-sm text-gray-500 mt-10">
      &copy; 2025 Palmora - E-Commerce Produk Kelapa Sawit
    </div>
  </div>
</div>

<?php include 'Views/footer.php'; ?>
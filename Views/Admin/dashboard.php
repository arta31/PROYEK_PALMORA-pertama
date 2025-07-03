<?php 
session_start(); 
require '../middleware/auth.php'; 
include '../header.php'; 

// Hitung jumlah data
$stmt = $conn->query("SELECT COUNT(*) as total FROM users WHERE role != 'admin'");
$users = $stmt->fetch_assoc()['total'];

$stmt = $conn->query("SELECT COUNT(*) as total FROM products");
$products = $stmt->fetch_assoc()['total'];

$stmt = $conn->query("SELECT COUNT(*) as total FROM orders WHERE status = 'pending'");
$transactions = $stmt->fetch_assoc()['total'];
?>

<div class="md:ml-64 p-6">
  <h2 class="text-2xl font-semibold mb-6">Dashboard Admin</h2>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white p-4 rounded shadow text-center">
      <h3 class="text-lg font-bold">Total Pengguna</h3>
      <p class="text-3xl"><?= $users ?></p>
    </div>
    <div class="bg-white p-4 rounded shadow text-center">
      <h3 class="text-lg font-bold">Total Produk</h3>
      <p class="text-3xl"><?= $products ?></p>
    </div>
    <div class="bg-white p-4 rounded shadow text-center">
      <h3 class="text-lg font-bold">Transaksi Hari Ini</h3>
      <p class="text-3xl"><?= $transactions ?></p>
    </div>
  </div>
</div>

<?php include '../footer.php'; ?>
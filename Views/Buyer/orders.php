<?php 
session_start(); 
require '../middleware/auth.php';
include '../header.php'; 

require '../../Models/OrderModel.php';
$orderModel = new OrderModel($conn);

$orders = $orderModel->getOrdersByCustomerId($_SESSION['user']['id']);
?>

<div class="md:ml-64 p-6">
  <h2 class="text-2xl font-semibold mb-6">Riwayat Pesanan</h2>

  <?php if (isset($_SESSION['success'])): ?>
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
  <?php endif; ?>

  <?php if (empty($orders)): ?>
    <p class="bg-white shadow rounded p-6 text-center text-gray-500">Belum ada pesanan.</p>
  <?php else: ?>
    <!-- Daftar Pesanan -->
    <?php 
    $grouped = [];
    foreach ($orders as $o) $grouped[$o['order_id']][] = $o;
    foreach ($grouped as $oid => $items): ?>
      <div class="bg-white shadow rounded overflow-hidden mb-4">
        <div class="p-4 bg-gray-50 border-b">
          <span class="font-medium">Pesanan #<?= $oid ?></span> |
          <span>Tanggal: <?= date('d M Y', strtotime($items[0]['created_at'])) ?></span> |
          <span>Status:
            <span class="inline-block px-2 py-1 rounded text-white text-xs
              <?= $items[0]['status'] == 'pending' ? 'bg-yellow-500' : '' ?>
              <?= $items[0]['status'] == 'paid' ? 'bg-green-500' : '' ?>
              <?= $items[0]['status'] == 'cancel' ? 'bg-red-500' : '' ?>">
              <?= ucfirst($items[0]['status']) ?>
            </span>
          </span>
        </div>
        <table class="w-full table-auto">
          <thead class="bg-gray-100">
            <tr>
              <th class="px-4 py-2">Produk</th>
              <th class="px-4 py-2">Harga</th>
              <th class="px-4 py-2">Qty</th>
              <th class="px-4 py-2">Subtotal</th>
            </tr>
          </thead>
          <tbody>
            <?php $total = 0; foreach ($items as $item): $total += $item['price'] * $item['quantity']; ?>
              <tr class="border-b">
                <td class="px-4 py-2 flex items-center">
                  <img src="<?= $item['image'] ?>" alt="<?= $item['product_name'] ?>" class="w-10 h-10 object-cover mr-2">
                  <?= $item['product_name'] ?>
                </td>
                <td class="px-4 py-2">Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                <td class="px-4 py-2"><?= $item['quantity'] ?></td>
                <td class="px-4 py-2">Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?></td>
              </tr>
            <?php endforeach; ?>
            <tr class="bg-gray-50">
              <td colspan="3" class="px-4 py-2 font-bold">Total Harga</td>
              <td class="px-4 py-2 font-bold">Rp <?= number_format(array_sum(array_map(fn($x) => $x['price'] * $x['quantity'], $items)), 0, ',', '.') ?></td>
            </tr>
          </tbody>
        </table>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

<?php include '../footer.php'; ?>
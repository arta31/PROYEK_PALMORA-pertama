<?php
session_start();
require '../middleware/auth.php';
include '../header.php';

require '../../Models/OrderModel.php';
$orderModel = new OrderModel($conn);

$order_id = $_GET['id'] ?? null;
if (!$order_id) {
    $_SESSION['error'] = "ID pesanan tidak ditemukan.";
    header("Location: order_status.php");
    exit();
}

$items = $orderModel->getOrderById($order_id);
if (empty($items)) {
    $_SESSION['error'] = "Pesanan tidak ditemukan.";
    header("Location: order_status.php");
    exit();
}
?>

<div class="md:ml-64 p-6">
  <h2 class="text-2xl font-semibold mb-6">Detail Pesanan #<?= $order_id ?></h2>

  <div class="bg-white shadow rounded overflow-hidden">
    <table class="w-full table-auto">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-4 py-2">Produk</th>
          <th class="px-4 py-2">Harga</th>
          <th class="px-4 py-2">Jumlah</th>
          <th class="px-4 py-2">Subtotal</th>
        </tr>
      </thead>
      <tbody>
        <?php $total = 0; foreach ($items as $item): $total += $item['price'] * $item['quantity']; ?>
          <tr class="border-b">
            <td class="px-4 py-2 flex items-center">
              <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>" class="w-10 h-10 object-cover mr-3">
              <?= htmlspecialchars($item['product_name']) ?>
            </td>
            <td class="px-4 py-2">Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
            <td class="px-4 py-2"><?= $item['quantity'] ?></td>
            <td class="px-4 py-2">Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?></td>
          </tr>
        <?php endforeach; ?>
        <tr class="bg-gray-50">
          <td colspan="3" class="px-4 py-2 font-bold">Total Pembayaran</td>
          <td class="px-4 py-2 font-bold">Rp <?= number_format($total, 0, ',', '.') ?></td>
        </tr>
      </tbody>
    </table>
    <div class="p-4 bg-blue-50 text-blue-800">
      Status: <strong><?= ucfirst($items[0]['status']) ?></strong><br>
      Tanggal: <?= date('d M Y H:i', strtotime($items[0]['created_at'])) ?>
    </div>
  </div>
</div>

<?php include '../footer.php'; ?>
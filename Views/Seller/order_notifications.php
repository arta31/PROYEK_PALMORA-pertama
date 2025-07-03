<?php
session_start();
require '../middleware/auth.php';
include '../header.php';

require '../../Models/OrderModel.php';
$orderModel = new OrderModel($conn);

$seller_id = $_SESSION['user']['id'];
$orders = $orderModel->getOrdersBySellerId($seller_id);
$unreadCount = $orderModel->countUnreadOrders($seller_id);
?>

<div class="md:ml-64 p-6">
  <h2 class="text-2xl font-semibold mb-6">Notifikasi Pesanan</h2>

  <?php if ($unreadCount > 0): ?>
    <div class="bg-yellow-100 text-yellow-800 p-3 rounded mb-4">
      Ada <?= $unreadCount ?> pesanan baru.
    </div>
  <?php endif; ?>

  <div class="bg-white shadow rounded overflow-hidden">
    <table class="w-full table-auto">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-4 py-2">#</th>
          <th class="px-4 py-2">Produk</th>
          <th class="px-4 py-2">Pelanggan</th>
          <th class="px-4 py-2">Total Harga</th>
          <th class="px-4 py-2">Tanggal</th>
          <th class="px-4 py-2">Status</th>
          <th class="px-4 py-2">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($orders)): $no = 1; foreach ($orders as $o): ?>
          <tr class="<?= $o['is_read'] == 0 ? 'bg-blue-50' : '' ?>">
            <td class="border px-4 py-2 text-center"><?= $no++ ?></td>
            <td class="border px-4 py-2"><?= htmlspecialchars($o['product_name']) ?></td>
            <td class="border px-4 py-2"><?= htmlspecialchars($o['customer_name']) ?></td>
            <td class="border px-4 py-2">Rp <?= number_format($o['total_price'], 0, ',', '.') ?></td>
            <td class="border px-4 py-2"><?= date('d M Y', strtotime($o['created_at'])) ?></td>
            <td class="border px-4 py-2">
              <span class="inline-block px-2 py-1 rounded text-white text-xs 
                <?= $o['status'] == 'pending' ? 'bg-yellow-500' : '' ?>
                <?= $o['status'] == 'paid' ? 'bg-green-500' : '' ?>
                <?= $o['status'] == 'cancel' ? 'bg-red-500' : '' ?>">
                <?= ucfirst($o['status']) ?>
              </span>
            </td>
            <td class="border px-4 py-2 text-center">
              <a href="order_details.php?id=<?= $o['order_id'] ?>" class="text-indigo-600 hover:underline">Lihat</a>
            </td>
          </tr>
        <?php endforeach; else: ?>
          <tr>
            <td colspan="7" class="text-center py-4">Tidak ada notifikasi.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include '../footer.php'; ?>
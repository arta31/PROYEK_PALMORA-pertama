<?php
session_start();
require '../middleware/auth.php';
include '../header.php';

require '../../Models/OrderModel.php';
$orderModel = new OrderModel($conn);

$stmt = $conn->prepare("
    SELECT o.id AS order_id, o.total_price, o.status, o.created_at,
           u.name AS customer_name, p.name AS product_name
    FROM orders o
    JOIN users u ON o.customer_id = u.id
    JOIN order_items oi ON o.id = oi.order_id
    JOIN products p ON oi.product_id = p.id
    GROUP BY o.id
    ORDER BY o.created_at DESC
");
$stmt->execute();
$result = $stmt->get_result();
$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}
?>

<div class="md:ml-64 p-6">
  <h2 class="text-2xl font-semibold mb-6">Kelola Transaksi</h2>

  <?php if (isset($_SESSION['success'])): ?>
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
  <?php endif; ?>

  <div class="bg-white shadow rounded overflow-hidden">
    <table class="w-full table-auto">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-4 py-2">#</th>
          <th class="px-4 py-2">Pelanggan</th>
          <th class="px-4 py-2">Produk</th>
          <th class="px-4 py-2">Total Harga</th>
          <th class="px-4 py-2">Tanggal</th>
          <th class="px-4 py-2">Status</th>
          <th class="px-4 py-2">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($orders)): $no = 1; foreach ($orders as $o): ?>
          <tr>
            <td class="border px-4 py-2 text-center"><?= $no++ ?></td>
            <td class="border px-4 py-2"><?= htmlspecialchars($o['customer_name']) ?></td>
            <td class="border px-4 py-2"><?= htmlspecialchars($o['product_name']) ?></td>
            <td class="border px-4 py-2">Rp <?= number_format($o['total_price'], 0, ',', '.') ?></td>
            <td class="border px-4 py-2"><?= date('d M Y', strtotime($o['created_at'])) ?></td>
            <td class="border px-4 py-2">
              <form action="../../Controllers/OrderController.php?action=update_status" method="POST">
                <input type="hidden" name="order_id" value="<?= $o['order_id'] ?>">
                <select name="status" onchange="this.form.submit()" class="border rounded p-1 text-sm">
                  <option value="pending" <?= $o['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                  <option value="paid" <?= $o['status'] == 'paid' ? 'selected' : '' ?>>Paid</option>
                  <option value="cancel" <?= $o['status'] == 'cancel' ? 'selected' : '' ?>>Cancel</option>
                </select>
              </form>
            </td>
            <td class="border px-4 py-2 text-center">
              <a href="../../Controllers/OrderController.php?action=view&id=<?= $o['order_id'] ?>" class="text-blue-500 hover:underline">Lihat Detail</a>
            </td>
          </tr>
        <?php endforeach; else: ?>
          <tr>
            <td colspan="7" class="text-center py-4">Belum ada transaksi.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include '../footer.php'; ?>
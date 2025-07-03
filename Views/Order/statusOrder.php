<?php
session_start();
require '../middleware/auth.php';
include '../header.php';

if (!isset($_SESSION['order_details'])) {
    header("Location: ../Buyer/orders.php");
    exit();
}

$details = $_SESSION['order_details'];
unset($_SESSION['order_details']);
?>

<div class="md:ml-64 p-6">
  <h2 class="text-2xl font-semibold mb-6">Detail Pesanan</h2>

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
        <?php $total = 0; foreach ($details as $d): $total += $d['price'] * $d['quantity']; ?>
          <tr class="border-b">
            <td class="border px-4 py-2"><?= htmlspecialchars($d['product_name']) ?></td>
            <td class="border px-4 py-2">Rp <?= number_format($d['price'], 0, ',', '.') ?></td>
            <td class="border px-4 py-2"><?= $d['quantity'] ?></td>
            <td class="border px-4 py-2">Rp <?= number_format($d['price'] * $d['quantity'], 0, ',', '.') ?></td>
          </tr>
        <?php endforeach; ?>
        <tr class="bg-gray-50">
          <td colspan="3" class="px-4 py-2 font-bold">Total Pembayaran</td>
          <td class="px-4 py-2 font-bold">Rp <?= number_format($total, 0, ',', '.') ?></td>
        </tr>
      </tbody>
    </table>
    <div class="p-4 bg-blue-50 text-blue-800">
      Status: <strong><?= ucfirst($details[0]['status']) ?></strong><br>
      Tanggal: <?= date('d M Y H:i', strtotime($details[0]['created_at'])) ?>
    </div>
  </div>
</div>

<?php include '../footer.php'; ?>
<?php
session_start();
require '../../Cores/dbPalmora.php';
require '../../Models/OrderModel.php';

$orderModel = new OrderModel($conn);

$action = $_GET['action'] ?? '';

if ($action == 'update_status') {
    $orderId = $_POST['order_id'];
    $newStatus = $_POST['status'];

    if ($orderModel->updateOrderStatus($orderId, $newStatus)) {
        $_SESSION['success'] = "Status pesanan berhasil diperbarui.";
    } else {
        $_SESSION['error'] = "Gagal memperbarui status pesanan.";
    }

    $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../Admin/transaction.php';
    header("Location: $redirect");
    exit();

} elseif ($action == 'view') {
    $order_id = $_GET['id'];
    $stmt = $conn->prepare("
        SELECT o.*, u.name AS customer_name, p.name AS product_name, oi.quantity, oi.price 
        FROM orders o 
        JOIN users u ON o.customer_id = u.id 
        JOIN order_items oi ON o.id = oi.order_id 
        JOIN products p ON oi.product_id = p.id 
        WHERE o.id = ?
    ");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
    $_SESSION['order_details'] = $items;
    header("Location: ../../Views/Order/statusOrder.php");
    exit();
}
?>
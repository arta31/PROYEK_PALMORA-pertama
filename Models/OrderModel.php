<?php
class OrderModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Ambil semua pesanan berdasarkan customer_id
    public function getOrdersByCustomerId($customer_id) {
        $stmt = $this->conn->prepare("
            SELECT o.id AS order_id, o.total_price, o.status, o.created_at,
                   p.name AS product_name, oi.quantity, p.image, p.price
            FROM orders o
            JOIN order_items oi ON o.id = oi.order_id
            JOIN products p ON oi.product_id = p.id
            WHERE o.customer_id = ?
            ORDER BY o.created_at DESC
        ");
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Ambil pesanan berdasarkan ID
    public function getOrderById($order_id) {
        $stmt = $this->conn->prepare("
            SELECT o.id AS order_id, o.total_price, o.status, o.created_at,
                   p.name AS product_name, oi.quantity, p.image, p.price
            FROM orders o
            JOIN order_items oi ON o.id = oi.order_id
            JOIN products p ON oi.product_id = p.id
            WHERE o.id = ?
        ");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Update status pesanan
    public function updateOrderStatus($orderId, $status) {
        $stmt = $this->conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $orderId);
        return $stmt->execute();
    }

    // Ambil semua pesanan terkait seller
    public function getOrdersBySellerId($seller_id) {
        $stmt = $this->conn->prepare("
            SELECT o.id AS order_id, o.total_price, o.status, o.created_at,
                   p.name AS product_name, u.name AS customer_name
            FROM orders o
            JOIN order_items oi ON o.id = oi.order_id
            JOIN products p ON oi.product_id = p.id
            JOIN users u ON o.customer_id = u.id
            WHERE p.seller_id = ?
            ORDER BY o.created_at DESC
        ");
        $stmt->bind_param("i", $seller_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Hitung jumlah pesanan belum dibaca untuk seller
    public function countUnreadOrders($seller_id) {
        $stmt = $this->conn->prepare("
            SELECT COUNT(*) as total 
            FROM orders o
            JOIN order_items oi ON o.id = oi.order_id
            JOIN products p ON oi.product_id = p.id
            WHERE p.seller_id = ? AND o.is_read = 0
        ");
        $stmt->bind_param("i", $seller_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total'];
    }
}
?>
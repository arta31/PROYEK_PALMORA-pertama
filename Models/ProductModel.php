<?php
class ProductModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Ambil semua produk
    public function getAllProducts() {
        $sql = "SELECT p.*, u.name as seller_name FROM products p JOIN users u ON p.seller_id = u.id ORDER BY p.created_at DESC";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Ambil produk berdasarkan ID
    public function getProductById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Tambah produk baru
    public function addProduct($data, $imagePath) {
        $stmt = $this->conn->prepare("INSERT INTO products (seller_id, name, price, description, image, type) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ississs", $data['seller_id'], $data['name'], $data['price'], $data['description'], $imagePath, $data['type']);
        return $stmt->execute();
    }
}
?>
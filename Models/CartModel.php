<?php
class CartModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Ambil semua item keranjang berdasarkan user_id
    public function getCartItems($user_id) {
        $stmt = $this->conn->prepare("
            SELECT c.id AS cart_id, p.name AS product_name, p.image, p.price, c.quantity 
            FROM cart c 
            JOIN products p ON c.product_id = p.id 
            WHERE c.user_id = ?
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Tambah produk ke keranjang
    public function addToCart($user_id, $product_id, $quantity = 1) {
        $stmt = $this->conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $user_id, $product_id, $quantity);
        return $stmt->execute();
    }

    // Hapus item dari keranjang
    public function removeFromCart($cart_id) {
        $stmt = $this->conn->prepare("DELETE FROM cart WHERE id = ?");
        $stmt->bind_param("i", $cart_id);
        return $stmt->execute();
    }

    // Kosongkan seluruh isi keranjang
    public function clearCart($user_id) {
        $stmt = $this->conn->prepare("DELETE FROM cart WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        return $stmt->execute();
    }
}
?>
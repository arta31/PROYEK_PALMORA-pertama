<?php
session_start();
require '../../Cores/palmora.php';
require '../../Models/CartModel.php';
require '../../Models/OrderModel.php';

$cartModel = new CartModel($conn);
$orderModel = new OrderModel($conn);

$action = $_GET['action'] ?? '';

if ($action == 'add') {
    $user_id = $_SESSION['user']['id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'] ?? 1;

    if ($cartModel->addToCart($user_id, $product_id, $quantity)) {
        $_SESSION['success'] = "Produk berhasil ditambahkan ke keranjang.";
    } else {
        $_SESSION['error'] = "Gagal menambahkan produk ke keranjang.";
    }

    header("Location: ../../Views/Cart/index.php");
    exit();

} elseif ($action == 'remove') {
    $cart_id = $_GET['id'];

    if ($cartModel->removeFromCart($cart_id)) {
        $_SESSION['success'] = "Item berhasil dihapus dari keranjang.";
    } else {
        $_SESSION['error'] = "Gagal menghapus item dari keranjang.";
    }

    header("Location: ../../Views/Cart/index.php");
    exit();

} elseif ($action == 'clear') {
    $user_id = $_SESSION['user']['id'];
    $cartModel->clearCart($user_id);
    $_SESSION['success'] = "Keranjang berhasil dikosongkan.";

    header("Location: ../../Views/Cart/index.php");
    exit();

} elseif ($action == 'checkout') {
    $user_id = $_SESSION['user']['id'];
    $cartItems = $cartModel->getCartItems($user_id);

    if (empty($cartItems)) {
        $_SESSION['error'] = "Keranjang kosong!";
        header("Location: ../../Views/Cart/index.php");
        exit();
    }

    // Mulai transaksi
    $conn->begin_transaction();

    try {
        // Buat order utama
        $total_price = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cartItems));
        $stmt = $conn->prepare("INSERT INTO orders (customer_id, total_price, status) VALUES (?, ?, 'pending')");
        $stmt->bind_param("ii", $user_id, $total_price);
        $stmt->execute();
        $order_id = $stmt->insert_id;

        // Tambahkan item ke order_items
        foreach ($cartItems as $item) {
            $product_id = $item['product_id'];
            $quantity = $item['quantity'];
            $price = $item['price'];
            $stmtItem = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            $stmtItem->bind_param("iiii", $order_id, $product_id, $quantity, $price);
            $stmtItem->execute();
        }

        // Kosongkan keranjang
        $cartModel->clearCart($user_id);

        // Commit transaksi
        $conn->commit();

        // Redirect ke halaman konfirmasi
        $_SESSION['order_id'] = $order_id;
        header("Location: ../../Views/Cart/order_confirmation.php");
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['error'] = "Terjadi kesalahan saat checkout: " . $e->getMessage();
        header("Location: ../../Views/Cart/index.php");
        exit();
    }
}
?>
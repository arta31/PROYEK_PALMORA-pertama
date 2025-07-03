<?php
session_start();
require '../../Cores/dbPalmora.php';
require '../../Models/ProductModel.php';

$productModel = new ProductModel($conn);

$action = $_GET['action'] ?? '';

if ($action == 'add') {
    $allowedTypes = ['jpg', 'jpeg', 'png'];
    $maxSize = 2 * 1024 * 1024; // 2MB

    if (!isset($_FILES['image']) || $_FILES['image']['error'] != UPLOAD_ERR_OK) {
        $_SESSION['error'] = "Gagal mengunggah gambar.";
        header("Location: ../../Views/Seller/manage_products.php");
        exit();
    }

    $fileType = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    if (!in_array($fileType, $allowedTypes)) {
        $_SESSION['error'] = "Hanya file JPG, JPEG, dan PNG yang diperbolehkan.";
        header("Location: ../../Views/Seller/manage_products.php");
        exit();
    }

    if ($_FILES['image']['size'] > $maxSize) {
        $_SESSION['error'] = "Ukuran file tidak boleh lebih dari 2MB.";
        header("Location: ../../Views/Seller/manage_products.php");
        exit();
    }

    $target_dir = "../../assets/uploads/products/";
    $newFileName = uniqid() . "." . $fileType;
    $target_file = $target_dir . $newFileName;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $data = [
            'seller_id' => $_SESSION['user']['id'],
            'name' => $_POST['name'],
            'price' => $_POST['price'],
            'description' => $_POST['description'],
            'type' => $_POST['type']
        ];
        $imagePath = "assets/uploads/products/" . $newFileName;

        if ($productModel->addProduct($data, $imagePath)) {
            $_SESSION['success'] = "Produk berhasil ditambahkan.";
        } else {
            $_SESSION['error'] = "Gagal menyimpan produk ke database.";
            unlink($target_file); // Hapus file jika gagal simpan ke DB
        }
    } else {
        $_SESSION['error'] = "Gagal memindahkan file yang diunggah.";
    }

    header("Location: ../../Views/Seller/manage_products.php");
    exit();

} elseif ($action == 'delete') {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $_SESSION['success'] = "Produk berhasil dihapus.";
    } else {
        $_SESSION['error'] = "Gagal menghapus produk.";
    }
    header("Location: ../../Views/Seller/manage_products.php");
}
?>
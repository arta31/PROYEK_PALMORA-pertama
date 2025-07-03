<?php
session_start();
require '../../Cores/dbPalmora.php';
require '../../Models/CategoryModel.php';

$categoryModel = new CategoryModel($conn);

$action = $_GET['action'] ?? '';

if ($action == 'add') {
    $name = trim($_POST['name']);
    if (!empty($name)) {
        if ($categoryModel->addCategory($name)) {
            $_SESSION['success'] = "Kategori berhasil ditambahkan.";
        } else {
            $_SESSION['error'] = "Gagal menambahkan kategori.";
        }
    } else {
        $_SESSION['error'] = "Nama kategori tidak boleh kosong.";
    }
    header("Location: ../Admin/category_management.php");
    exit();

} elseif ($action == 'update') {
    $id = $_POST['id'];
    $name = trim($_POST['name']);
    if (!empty($name)) {
        if ($categoryModel->updateCategory($id, $name)) {
            $_SESSION['success'] = "Kategori berhasil diperbarui.";
        } else {
            $_SESSION['error'] = "Gagal memperbarui kategori.";
        }
    } else {
        $_SESSION['error'] = "Nama kategori tidak boleh kosong.";
    }
    header("Location: ../Admin/category_management.php");
    exit();

} elseif ($action == 'delete') {
    $id = $_GET['id'];
    if ($categoryModel->deleteCategory($id)) {
        $_SESSION['success'] = "Kategori berhasil dihapus.";
    } else {
        $_SESSION['error'] = "Gagal menghapus kategori.";
    }
    header("Location: ../Admin/category_management.php");
    exit();
}
?>
<?php
session_start();
require '../../Cores/dbPalmora.php';
require '../../Models/UserModel.php';

$userModel = new UserModel($conn);

$action = $_GET['action'] ?? '';

if ($action == 'toggle') {
    $id = $_GET['id'];
    if ($userModel->toggleUserStatus($id)) {
        $_SESSION['success'] = "Status pengguna berhasil diubah.";
    } else {
        $_SESSION['error'] = "Gagal mengubah status pengguna.";
    }
    header("Location: ../Admin/user_management.php");
    exit();

} elseif ($action == 'delete') {
    $id = $_GET['id'];
    if ($userModel->deleteUser($id)) {
        $_SESSION['success'] = "Pengguna berhasil dihapus.";
    } else {
        $_SESSION['error'] = "Gagal menghapus pengguna.";
    }
    header("Location: ../Admin/user_management.php");
    exit();

} elseif ($action == 'add') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (!empty($name) && !empty($email) && !empty($password) && in_array($role, ['seller', 'buyer'])) {
        if ($userModel->addUser($name, $email, $password, $role)) {
            $_SESSION['success'] = "Pengguna berhasil ditambahkan.";
        } else {
            $_SESSION['error'] = "Gagal menambahkan pengguna.";
        }
    } else {
        $_SESSION['error'] = "Semua field harus diisi dan role harus valid.";
    }
    header("Location: ../Admin/user_management.php");
    exit();
}
?>
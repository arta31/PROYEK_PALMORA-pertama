<?php
session_start();
require '../../Cores/dbPalmora.php';

$action = $_GET['action'] ?? '';

if ($action == 'login') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            switch ($user['role']) {
                case 'admin': header("Location: ../Views/Admin/dashboard.php"); break;
                case 'seller': header("Location: ../Views/Seller/dashboard.php"); break;
                default: header("Location: ../Views/Buyer/dashboard.php");
            }
            exit();
        } else {
            $_SESSION['error'] = "Password salah.";
            header("Location: ../Views/User/login.php");
        }
    } else {
        $_SESSION['error'] = "Email tidak ditemukan.";
        header("Location: ../Views/User/login.php");
    }

} elseif ($action == 'register') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'buyer';

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $password, $role);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Registrasi berhasil. Silakan login.";
        header("Location: ../Views/User/login.php");
    } else {
        $_SESSION['error'] = "Gagal mendaftar.";
        header("Location: ../Views/User/register.php");
    }

} elseif ($action == 'logout') {
    session_destroy();
    header("Location: ../index.php");
}
?>
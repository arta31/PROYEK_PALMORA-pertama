<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../Views/User/login.php");
    exit();
}

$allowedRoles = ['admin', 'seller', 'buyer'];
$requestedPage = basename($_SERVER['PHP_SELF']);

if (strpos($_SERVER['REQUEST_URI'], '/Admin/') !== false) {
    $allowedRoles = ['admin'];
} elseif (strpos($_SERVER['REQUEST_URI'], '/Seller/') !== false) {
    $allowedRoles = ['seller'];
} elseif (strpos($_SERVER['REQUEST_URI'], '/Buyer/') !== false) {
    $allowedRoles = ['buyer'];
}

$userRole = $_SESSION['user']['role'];

if (!in_array($userRole, $allowedRoles)) {
    header("Location: ../../index.php");
    exit();
}
?>
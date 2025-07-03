<?php
$host = "localhost";
$username = "root"; // Sesuaikan dengan konfigurasi Anda
$password = "";     // Sesuaikan dengan konfigurasi Anda
$database = "palmora";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
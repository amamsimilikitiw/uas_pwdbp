<?php
$host = "localhost";     // biasanya localhost
$user = "root";          // user default XAMPP
$pass = "";              // kosongkan jika pakai XAMPP tanpa password
$db   = "marketplace_game"; // nama database kamu

// Buat koneksi
$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>

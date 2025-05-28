<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = $conn->query("SELECT * FROM users WHERE username = '$username'");
    $user = $query->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['login'] = true;
        $_SESSION['username'] = $user['username'];
        echo "<script>alert('Login berhasil!'); window.location='index.php';</script>";
    } else {
        echo "Login gagal. Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Login</title>
<link rel="stylesheet" href="assets/style.css"></head>
<body>
    <header><nav class="navbar">
    <div class="logo-container">
    <img src="img/logo.png" alt="Logo" class="logo-img">
    <h1 class="judul-logo">AmmStore</h1>
    </div>
    <ul class="nav-links">
        <li><a href="index.php">Beranda</a></li>
    <li><a href="add_account.php">Tambah Akun</a></li>
    <li><a href="perhatian.php">Perhatian</a></li>
    <li><a href="testimoni.php">Testimoni</a></li>
    <li><a href="kontak.php">Hubungi</a></li>
    <li><a href="login.php">Login</a></li>
    </ul>
</nav>'
</header>
    <h2>Form Login</h2>
    <form method="POST">
        <label>Email:</label><br>
        <input type="text" name="username" required><br>
        
        <label>Password:</label><br>
        <input type="password" name="password" required><br>
        
        <input type="submit" value="Login">
    </form>
    <p class="center-text">Belum punya akun? <a href="register.php">Daftar di sini</a></p>

</body>
</html>

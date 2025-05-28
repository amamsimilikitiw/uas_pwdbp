<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Cek apakah username sudah ada
    $cek = $conn->query("SELECT * FROM users WHERE username = '$username'");
    if ($cek->num_rows > 0) {
        echo "Username sudah digunakan!";
    } else {
        $query = $conn->query("INSERT INTO users (username, password) VALUES ('$username', '$password')");
        if ($query) {
            echo "<script>alert('Registrasi berhasil!'); window.location='login.php';</script>";
        } else {
            echo "Registrasi gagal.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Register</title>
<link rel="stylesheet" href="assets/style.css"></head>
<body>
    <h2>Form Registrasi</h2>
    <form method="POST">
        <label>Username:</label><br>
        <input type="text" name="username" required><br>
        
        <label>Password:</label><br>
        <input type="password" name="password" required><br>
        
        <input type="submit" value="Register">
    </form>
    <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
</body>
</html>

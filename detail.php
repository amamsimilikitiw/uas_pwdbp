<?php
include 'db.php';

if (!isset($_GET['id'])) {
    die("ID tidak ditemukan.");
}

$id = intval($_GET['id']); // untuk keamanan, hindari SQL injection
$query = $conn->query("SELECT * FROM accounts WHERE id = $id");

if (!$query || $query->num_rows == 0) {
    die("Data tidak ditemukan.");
}

$data = $query->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Akun</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
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
</nav>
<div class="akun-card">
<h2><?= htmlspecialchars($data['account_title']) ?> (<?= htmlspecialchars($data['game_id']) ?>)</h2>

<?php if (!empty($data['image'])): ?>
    <div class="akun-img">
        <img src="uploads/<?= htmlspecialchars($data['image']) ?>" alt="Akun <?= htmlspecialchars($data['game_id']) ?>" />
    </div>
<?php endif; ?>

<p class="harga"><strong>Rp<?= number_format($data['price'], 0, ',', '.') ?></strong></p>
<p class="deskripsi"><?= nl2br(htmlspecialchars($data['description'])) ?></p>

<div class="social-buttons">
    <a href="https://www.instagram.com/ammmmstore/" target="_blank" class="btn-instagram">
    <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/instagram.svg" alt="Instagram" /> Instagram
    </a>
    <a href="https://wa.me/6285174287275" target="_blank" class="btn-whatsapp">
    <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/whatsapp.svg" alt="WhatsApp" /> WhatsApp
    </a>
</div>
</div>


</body>
</html>

<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Marketplace Akun Game</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<header>
    <nav class="navbar">
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
</header>
<br>
<br>
<br>

<main>
    <h1>Temukan Game Anda Disini!</h1>
    <div class="game-container">
        <?php
        // Mengambil daftar game dari database
        $query_games = $conn->query("SELECT id, name FROM games ORDER BY name ASC");

        if ($query_games && $query_games->num_rows > 0) {
            while ($game_row = $query_games->fetch_assoc()) {
                $game_id = $game_row['id'];
                $game_name = htmlspecialchars($game_row['name']);

                // Mengubah nama game menjadi format slug untuk nama file gambar
                // Contoh: "Mobile Legends" -> "mobile_legends"
                // Perhatikan: ini asumsi penamaan gambar Anda.
                // Jika Anda menyimpan path gambar di kolom database (misal 'image_path' di tabel 'games'),
                // gunakan itu: $image_src = htmlspecialchars($game_row['image_path']);
                $image_slug = strtolower(str_replace(' ', '_', $game_name));
                $image_src = "img/{$image_slug}.jpg"; // Asumsi ekstensi .jpg

                // Membangun URL untuk Belanja Game.
                // Disarankan untuk mengarahkan ke halaman yang menampilkan daftar akun untuk game_id tersebut.
                // Contoh: accounts_by_game.php?game_id=1
                $game_link = "accounts_by_game.php?game_id=" . $game_id; // Ganti dengan nama file PHP yang sesuai

                ?>
                <div class="game-card">
                    <img src="<?= $image_src ?>" alt="<?= $game_name ?>" class="game-image" />
                    <div class="game-info">
                        <h3><?= $game_name ?></h3>
                        <a href="<?= $game_link ?>" class="game-btn">Belanja Game</a>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p>Tidak ada game yang ditemukan di database.</p>";
        }
        $conn->close(); // Tutup koneksi setelah semua query selesai
        ?>
    </div>
</main>

<footer>
    <p>© <?= date('Y') ?> GameMarket - Jual beli akun game fantasy dengan aman dan cepat.</p>
</footer>

</body>
</html>


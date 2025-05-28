<?php
include 'koneksi.php'; // Pastikan ini mengarah ke file koneksi database Anda yang benar

// Ambil game_id dari URL
// (int)$_GET['game_id'] akan memastikan nilai yang diambil adalah integer
$selected_game_id = isset($_GET['game_id']) ? (int)$_GET['game_id'] : 0;

// Ambil nama game untuk ditampilkan di judul halaman
$game_name_title = "Daftar Akun Game"; // Default title
if ($selected_game_id > 0) {
    $game_title_query = $conn->prepare("SELECT name FROM games WHERE id = ?");
    $game_title_query->bind_param("i", $selected_game_id);
    $game_title_query->execute();
    $game_title_result = $game_title_query->get_result();
    if ($game_title_row = $game_title_result->fetch_assoc()) {
        $game_name_title = htmlspecialchars($game_title_row['name']);
    }
    $game_title_query->close();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $game_name_title ?> - Marketplace Akun Game</title>
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
        <h1>Daftar Akun untuk <?= $game_name_title ?></h1>
        <div class="grid">
            <?php
            // Hanya jalankan query jika game_id valid (lebih dari 0)
            if ($selected_game_id > 0) {
                // Query untuk mengambil akun hanya untuk game yang dipilih
                // Menggunakan prepared statement untuk keamanan
                $accounts_query = $conn->prepare("
                    SELECT accounts.*, games.name AS game_name_display
                    FROM accounts
                    JOIN games ON accounts.game_id = games.id
                    WHERE accounts.game_id = ?
                    ORDER BY accounts.id DESC
                ");
                $accounts_query->bind_param("i", $selected_game_id);
                $accounts_query->execute();
                $accounts_result = $accounts_query->get_result();

                if ($accounts_result->num_rows > 0) {
                    // Loop untuk menampilkan setiap akun
                    while ($row = $accounts_result->fetch_assoc()) :
                        // Gambar pertama dari daftar (jika ada koma) atau gambar tunggal
                        $image_files = explode(',', $row['image']);
                        $display_image = !empty($image_files[0]) ? 'uploads/' . htmlspecialchars($image_files[0]) : 'uploads/default.png'; // Pastikan ada default.png jika tidak ada gambar
            ?>
                    <div class="card">
                        <img src="<?= $display_image ?>" alt="<?= htmlspecialchars($row['account_title']) ?>" class="card-img">
                        <div class="card-content">
                            <h3><?= htmlspecialchars($row['account_title']) ?></h3>
                            <p><?= htmlspecialchars($row['game_name_display']) ?></p>
                            <p class="price">Rp <?= number_format($row['price'], 0, ',', '.') ?></p>
                            <div class="card-buttons">
                                <a href="detail.php?id=<?= $row['id'] ?>" class="btn btn-view"> Lihat</a>
                                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-edit"> Edit</a>
                                <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-delete" onclick="return confirm('Yakin ingin menghapus akun ini?')"> Hapus</a>
                            </div>
                        </div>
                    </div>
            <?php
                    endwhile;
                } else {
                    echo "<p>Tidak ada akun yang ditemukan untuk game " . $game_name_title . " ini.</p>";
                }
                $accounts_query->close();
            } else {
                echo "<p>Game tidak valid atau tidak dipilih. Silakan kembali ke <a href='index.php'>Beranda</a>.</p>";
            }
            // Disarankan untuk menutup koneksi di akhir script jika tidak ada query lain yang akan dijalankan
            // $conn->close();
            ?>
        </div>
    </main>

    <footer>
        <p>© <?= date('Y') ?> GameMarket - Jual beli akun game fantasy dengan aman dan cepat.</p>
    </footer>

</body>
</html>
<?php
include 'koneksi.php'; // Pastikan koneksi.php sudah terhubung ke database dengan benar

// --- Perbaikan 1: Inisialisasi variabel untuk menghindari "Undefined variable" warnings ---
$account_title = '';
$description = '';
$price = '';
// $game_id_selected = ''; // Jika Anda ingin mempertahankan pilihan game setelah error
// Inisialisasi variabel untuk pesan feedback
$message = '';
$message_type = ''; // 'success' atau 'error'

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari formulir
    $game_id = $_POST['game_id'] ?? null; // Pastikan nama input dropdown adalah 'game_id'
    $account_title = $_POST['account_title'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? '';

    // --- Opsional: Jika ingin mempertahankan pilihan game setelah error ---
    // if ($game_id) {
    //     $game_id_selected = $game_id;
    // }

    // Validasi data
    if (empty($game_id) || empty($account_title) || empty($description) || empty($price)) {
        $message = 'Semua kolom harus diisi.';
        $message_type = 'error';
    } else {
        // Proses upload gambar
        $target_dir = "uploads/";
        $image_name = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Cek apakah file gambar valid
        $check = @getimagesize($_FILES["image"]["tmp_name"]); // Gunakan @ untuk menekan warning jika bukan gambar
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $message = 'File bukan gambar.';
            $uploadOk = 0;
            $message_type = 'error';
        }

        // Cek jika file sudah ada
        if (file_exists($target_file)) {
            $message = 'Maaf, gambar sudah ada. Silakan ganti nama file atau pilih gambar lain.';
            $uploadOk = 0;
            $message_type = 'error';
        }

        // Batasi ukuran file (contoh: 5MB)
        if ($_FILES["image"]["size"] > 5000000) {
            $message = 'Maaf, ukuran gambar terlalu besar (maks 5MB).';
            $uploadOk = 0;
            $message_type = 'error';
        }

        // Izinkan format file tertentu
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            $message = 'Maaf, hanya format JPG, JPEG, PNG & GIF yang diizinkan.';
            $uploadOk = 0;
            $message_type = 'error';
        }

        // Jika ada error pada upload, jangan lanjutkan ke database
        if ($uploadOk == 0) {
            // Pesan error sudah diatur di atas
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // Gambar berhasil diupload, lanjutkan simpan data ke database
                $stmt = $conn->prepare("INSERT INTO accounts (game_id, account_title, description, price, image) VALUES (?, ?, ?, ?, ?)");
                // 'isdss' -> i: integer (game_id), s: string (account_title), d: double (price), s: string (description), s: string (image)
                // Sesuaikan 'd' dengan tipe data kolom price Anda (jika decimal/float, gunakan 'd'; jika int, gunakan 'i')
                $stmt->bind_param("isdss", $game_id, $account_title, $description, $price, $image_name);

                if ($stmt->execute()) {
                    $message = 'Akun berhasil ditambahkan!';
                    $message_type = 'success';
                    // Kosongkan form setelah sukses agar tidak ada data sebelumnya yang tertinggal
                    $account_title = '';
                    $description = '';
                    $price = '';
                    // $game_id_selected = ''; // Reset pilihan game
                } else {
                    $message = 'Error saat menyimpan data: ' . $stmt->error;
                    $message_type = 'error';
                }
                $stmt->close();
            } else {
                $message = 'Maaf, terjadi error saat mengunggah gambar.';
                $message_type = 'error';
            }
        }
    }
}

// --- Perbaikan 2: Ambil daftar game dari database untuk dropdown ---
$games = [];
// Pastikan tabel 'games' sudah ada dan terisi
$game_query = $conn->query("SELECT id, name FROM games ORDER BY name ASC");
if ($game_query) {
    while ($row = $game_query->fetch_assoc()) {
        $games[] = $row;
    }
} else {
    // Handle error jika query game gagal (misal tabel games tidak ada)
    $message = 'Error: Tidak dapat mengambil daftar game dari database. Pastikan tabel `games` ada dan terisi.';
    $message_type = 'error';
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Akun Baru</title>
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
<br><br><br>

<main>
    <div class="form-container">
        <h2>Tambah Akun Baru</h2>

        <?php if ($message): ?>
            <div class="message <?= $message_type ?>">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <form action="add_account.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="game_id">Pilih Game:</label>
                <select id="game_id" name="game_id" required>
                    <option value="">-- Pilih Game --</option>
                    <?php foreach ($games as $game): ?>
                        <option value="<?= $game['id'] ?>" <?= (isset($game_id_selected) && $game_id_selected == $game['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($game['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="account_title">Judul Akun:</label>
                <input type="text" id="account_title" name="account_title" value="<?= htmlspecialchars($account_title) ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Deskripsi Akun:</label>
                <textarea id="description" name="description" required><?= htmlspecialchars($description) ?></textarea>
            </div>

            <div class="form-group">
                <label for="price">Harga (Rp):</label>
                <input type="number" id="price" name="price" value="<?= htmlspecialchars($price) ?>" step="1000" min="0" required>
            </div>

            <div class="form-group">
                <label for="image">Gambar Akun:</label>
                <input type="file" id="image" name="image" accept="image/*" required>
            </div>

            <div class="form-group">
                <button type="submit">Tambah Akun</button>
            </div>
        </form>
    </div>
</main>

<footer>
    <p>© <?= date('Y') ?> GameMarket - Jual beli akun game fantasy dengan aman dan cepat.</p>
</footer>

</body>
</html>
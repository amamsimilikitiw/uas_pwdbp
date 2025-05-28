<?php
include 'koneksi.php';

if (!isset($_GET['id'])) {
    echo "ID tidak ditemukan.";
    exit;
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM accounts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    echo "Data tidak ditemukan.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $game_name = $_POST['game_id'];
    $title = $_POST['account_title'];
    $desc = $_POST['description'];
    $price = $_POST['price'];

    // Cek & upload gambar baru jika ada
    $image1 = $data['image'];
    if (!empty($_FILES['image']['name'])) {
        $image1 = time() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $image1);
    }

    $image2 = $data['image2'];
    if (!empty($_FILES['image2']['name'])) {
        $image2 = time() . "_2_" . basename($_FILES['image2']['name']);
        move_uploaded_file($_FILES['image2']['tmp_name'], "uploads/" . $image2);
    }

    $image3 = $data['image3'];
    if (!empty($_FILES['image3']['name'])) {
        $image3 = time() . "_3_" . basename($_FILES['image3']['name']);
        move_uploaded_file($_FILES['image3']['tmp_name'], "uploads/" . $image3);
    }

    // Gunakan prepared statement untuk update
    $stmt = $conn->prepare("UPDATE accounts SET game_id=?, account_title=?, description=?, price=?, image=?, image2=?, image3=? WHERE id=?");
    $stmt->bind_param("sssssssi", $game_name, $title, $desc, $price, $image1, $image2, $image3, $id);
    $update = $stmt->execute();

    if ($update) {
        echo "<script>alert('Data berhasil diupdate'); window.location='index.php';</script>";
    } else {
        echo "Gagal update data: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Akun</title>
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
    <li><a href="perhatian.php">Perhatian!</a></li>
    <li><a href="testimoni.php">Testimoni</a></li>
    <li><a href="kontak.php">Hubungi</a></li>
    </ul>
</nav>'
</header>
<div class="container">
    <h1>Edit Akun Game</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <label>Nama Game:</label>
        <input type="text" name="game_id" value="<?= htmlspecialchars($data['game_id']) ?>" required>

        <label>Judul Akun:</label>
        <input type="text" name="account_title" value="<?= htmlspecialchars($data['account_title']) ?>" required>

        <label>Deskripsi:</label>
        <textarea name="description" rows="5"><?= htmlspecialchars($data['description']) ?></textarea>

        <label>Harga:</label>
        <input type="number" name="price" step="1" value="<?= htmlspecialchars($data['price']) ?>" />

        <label>Gambar Utama:</label><br>
        <?php if ($data['image']) : ?>
            <img src="uploads/<?= htmlspecialchars($data['image']) ?>" width="150"><br>
        <?php endif; ?>
        <input type="file" name="image">

        <label>Gambar Tambahan 1:</label><br>
        <?php if ($data['image2']) : ?>
            <img src="uploads/<?= htmlspecialchars($data['image2']) ?>" width="150"><br>
        <?php endif; ?>
        <input type="file" name="image2">

        <label>Gambar Tambahan 2:</label><br>
        <?php if ($data['image3']) : ?>
            <img src="uploads/<?= htmlspecialchars($data['image3']) ?>" width="150"><br>
        <?php endif; ?>
        <input type="file" name="image3">

        <input type="submit" value="Update Akun">
    </form>
</div>
</body>
</html>

<?php
// Koneksi ke database
include 'koneksi.php';

// Cek apakah ada parameter ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil nama file gambar sebelum menghapus
    $query = $conn->query("SELECT image FROM accounts WHERE id = $id");
    $row = $query->fetch_assoc();
    $imagePath = 'uploads/' . $row['image'];

    // Hapus data dari database
    $delete = $conn->query("DELETE FROM accounts WHERE id = $id");

    if ($delete) {
        // Jika ada gambar, hapus juga dari folder uploads
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Redirect kembali ke index
        header("Location: index.php?msg=deleted");
    } else {
        echo "Gagal menghapus data.";
    }
} else {
    echo "ID tidak ditemukan.";
}
?>

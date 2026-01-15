<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: index.php");
    exit;
}
include '../../db/koneksi.php';

$id = $_GET['id'];

// 1. Ambil nama file dulu sebelum dihapus datanya
$stmt = $pdo->prepare("SELECT image FROM hero_slides WHERE id = ?");
$stmt->execute([$id]);
$data = $stmt->fetch();

if ($data) {
    // 2. Hapus file fisik dari folder assets/image
    $file_path = "../../assets/image/" . $data['image'];
    if (file_exists($file_path)) {
        unlink($file_path); // Fungsi PHP untuk menghapus file
    }

    // 3. Hapus data dari database
    $delete = $pdo->prepare("DELETE FROM hero_slides WHERE id = ?");
    $delete->execute([$id]);
}

header("location:index.php");
?>

<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: index.php");
    exit;
}
include '../../db/koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Hapus data dari database SAJA (Tidak perlu hapus file fisik karena pakai link)
    $del = $pdo->prepare("DELETE FROM events WHERE id = ?");
    $del->execute([$id]);
}

header("location:index.php");
?>

<?php
session_start();
include '../../db/koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 1. Ambil info gambar dulu sebelum data dihapus
    $stmt = $pdo->prepare("SELECT reward_img, bg_pattern_img FROM events WHERE id = ?");
    $stmt->execute([$id]);
    $data = $stmt->fetch();

    if ($data) {
        // 2. Hapus file fisik jika ada
        // Kita perlu tambah "../../" karena path di database disimpan sebagai "assets/image/..."
        // sedangkan posisi file hapus.php ada di admin/event/
        
        $file_reward = "../../" . $data['reward_img'];
        $file_pattern = "../../" . $data['bg_pattern_img'];

        if (file_exists($file_reward)) unlink($file_reward);
        if (file_exists($file_pattern)) unlink($file_pattern);

        // 3. Hapus data dari database
        $del = $pdo->prepare("DELETE FROM events WHERE id = ?");
        $del->execute([$id]);
    }
}

header("location:index.php");
?>

<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans">

    <nav class="bg-white shadow-md px-6 py-4 flex justify-between items-center sticky top-0 z-50">
        <div class="font-bold text-xl text-green-700 tracking-tight">CMS Bukit Jar'un</div>
        <div class="flex items-center gap-4">
            <span class="text-sm text-gray-600">Halo, <b><?= $_SESSION['username'] ?? 'Admin' ?></b></span>
            <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm transition shadow-sm">Logout</a>
        </div>
    </nav>

    <div class="container mx-auto p-6 max-w-6xl">
        <h1 class="text-3xl font-black text-gray-800 mb-2">Dashboard</h1>
        <p class="text-gray-500 mb-8">Selamat datang! Apa yang ingin kamu kelola hari ini?</p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <a href="input/input-ticket.php" class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-xl transition transform hover:-translate-y-1 border-l-8 border-purple-500 group">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-800 group-hover:text-purple-600 transition">Input Voucher</h2>
                    <div class="w-12 h-12 rounded-full bg-purple-50 flex items-center justify-center">
                        <i class="fas fa-ticket-alt text-xl text-purple-500"></i>
                    </div>
                </div>
                <p class="text-gray-500 text-sm">Input data voucher wisatawan.</p>
            </a>
            
            <a href="hero/index.php" class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-xl transition transform hover:-translate-y-1 border-l-8 border-blue-500 group">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-800 group-hover:text-blue-600 transition">Hero Slider</h2>
                    <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center">
                        <i class="fas fa-images text-xl text-blue-500"></i>
                    </div>
                </div>
                <p class="text-gray-500 text-sm">Kelola gambar banner utama website.</p>
            </a>

            <a href="event/index.php" class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-xl transition transform hover:-translate-y-1 border-l-8 border-yellow-400 group">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-800 group-hover:text-yellow-600 transition">Event List</h2>
                    <div class="w-12 h-12 rounded-full bg-yellow-50 flex items-center justify-center">
                        <i class="fas fa-calendar-check text-xl text-yellow-500"></i>
                    </div>
                </div>
                <p class="text-gray-500 text-sm">Kelola misi, hadiah, dan syarat event.</p>
            </a>

            <a href="lokasi/index.php" class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-xl transition transform hover:-translate-y-1 border-l-8 border-green-500 group">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-800 group-hover:text-green-600 transition">Info Lokasi</h2>
                    <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center">
                        <i class="fas fa-map-marked-alt text-xl text-green-500"></i>
                    </div>
                </div>
                <p class="text-gray-500 text-sm">Info Lokasi, Deskripsi, Alamat Lengkap.</p>
            </a>

            <a href="menfess/index.php" class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-xl transition transform hover:-translate-y-1 border-l-8 border-pink-500 group">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-800 group-hover:text-pink-600 transition">Menfess Manager</h2>
                    <div class="w-12 h-12 rounded-full bg-pink-50 flex items-center justify-center">
                        <i class="fas fa-envelope-open-text text-xl text-pink-500"></i>
                    </div>
                </div>
                <p class="text-gray-500 text-sm">Hapus pesan menfess yang tidak pantas.</p>
            </a>

            <a href="footer/index.php" class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-xl transition transform hover:-translate-y-1 border-l-8 border-slate-700 group">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-800 group-hover:text-slate-600 transition">Footer Setting</h2>
                    <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center">
                        <i class="fas fa-shoe-prints text-xl text-slate-700"></i>
                    </div>
                </div>
                <p class="text-gray-500 text-sm">Edit kontak, alamat, dan link sosmed.</p>
            </a>

            <a href="whatsapp-jarun/index.php" class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-xl transition transform hover:-translate-y-1 border-l-8 border-teal-500 group">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-800 group-hover:text-teal-600 transition">Token Bot WA</h2>
                    <div class="w-12 h-12 rounded-full bg-teal-50 flex items-center justify-center">
                        <i class="fab fa-whatsapp text-xl text-teal-500"></i>
                    </div>
                </div>
                <p class="text-gray-500 text-sm">Ganti Nomor/Token Fonnte Bot.</p>
            </a>

            <a href="setting-pesan/index.php" class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-xl transition transform hover:-translate-y-1 border-l-8 border-indigo-500 group">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-800 group-hover:text-indigo-600 transition">Template Pesan</h2>
                    <div class="w-12 h-12 rounded-full bg-indigo-50 flex items-center justify-center">
                        <i class="fas fa-comment-dots text-xl text-indigo-500"></i>
                    </div>
                </div>
                <p class="text-gray-500 text-sm">Ubah kata-kata notifikasi WA otomatis.</p>
            </a>

        </div>
    </div>

</body>
</html>

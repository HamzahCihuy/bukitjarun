<?php
session_start();

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
<body class="bg-gray-100">

    <nav class="bg-white shadow-md px-6 py-4 flex justify-between items-center">
        <div class="font-bold text-xl text-green-700">CMS Bukit Jar'un</div>
        <div class="flex items-center gap-4">
            <span>Halo, <b><?= $_SESSION['username'] ?></b></span>
            <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded text-sm">Logout</a>
        </div>
    </nav>

    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-700">Mau edit apa hari ini?</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <a href="hero/index.php" class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition transform hover:-translate-y-1 border-l-4 border-blue-500">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Hero Slider</h2>
                    <i class="fas fa-images text-3xl text-blue-200"></i>
                </div>
                <p class="text-gray-500 text-sm">Kelola gambar banner utama website.</p>
            </a>

            <a href="#" class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition transform hover:-translate-y-1 border-l-4 border-yellow-500 opacity-50 cursor-not-allowed">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Event List</h2>
                    <i class="fas fa-calendar-check text-3xl text-yellow-200"></i>
                </div>
                <p class="text-gray-500 text-sm">Segera Hadir.</p>
            </a>

            <a href="#" class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition transform hover:-translate-y-1 border-l-4 border-green-500 opacity-50 cursor-not-allowed">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Info Lokasi</h2>
                    <i class="fas fa-map-marked-alt text-3xl text-green-200"></i>
                </div>
                <p class="text-gray-500 text-sm">Segera Hadir.</p>
            </a>

        </div>
    </div>

</body>
</html>

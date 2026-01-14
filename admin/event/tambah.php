<?php
session_start();
include '../../db/koneksi.php';

// Fungsi Helper untuk Upload Gambar
function uploadGambar($fileInputName, $prefix) {
    $nama_file = $_FILES[$fileInputName]['name'];
    $tmp_file  = $_FILES[$fileInputName]['tmp_name'];
    $error     = $_FILES[$fileInputName]['error'];

    // Jika user tidak upload gambar (error 4), kembalikan null
    if ($error === 4) return null;

    $ekstensi  = pathinfo($nama_file, PATHINFO_EXTENSION);
    // Nama unik: icon_170222_judul.png
    $nama_baru = $prefix . "_" . time() . "." . $ekstensi;
    
    // Upload ke folder assets/image
    $destinasi = "../../assets/image/" . $nama_baru;
    
    if (move_uploaded_file($tmp_file, $destinasi)) {
        // Kita simpan path lengkapnya agar frontend tidak perlu diubah
        return "assets/image/" . $nama_baru;
    }
    return null;
}

if (isset($_POST['simpan'])) {
    $title      = $_POST['title'];
    $urutan     = $_POST['urutan'];
    $mission    = $_POST['mission'];
    $syarat     = $_POST['syarat'];
    $color_pri  = $_POST['color_primary'];
    $color_acc  = $_POST['color_accent'];

    // 1. Upload Reward Icon
    $path_reward = uploadGambar('reward_img', 'icon');
    // Jika gagal upload, pakai gambar default (opsional)
    if (!$path_reward) $path_reward = "assets/image/default_icon.png";

    // 2. Upload Pattern Background
    $path_pattern = uploadGambar('bg_pattern_img', 'pattern');
    if (!$path_pattern) $path_pattern = "assets/image/default_pattern.png";

    // 3. Simpan ke Database
    $sql = "INSERT INTO events (title, mission, syarat, reward_img, bg_pattern_img, color_primary, color_accent, urutan) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $mission, $syarat, $path_reward, $path_pattern, $color_pri, $color_acc, $urutan]);

    header("location:index.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Event Baru</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-10">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-3xl">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-4">📝 Buat Event Baru</h2>
        
        <form method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold mb-1">Judul Event</label>
                    <input type="text" name="title" required class="w-full border p-2 rounded focus:ring-2 focus:ring-green-400" placeholder="Contoh: Ikan Bakar Gratis">
                </div>
                <div>
                    <label class="block text-sm font-bold mb-1">Urutan</label>
                    <input type="number" name="urutan" value="1" class="w-full border p-2 rounded">
                </div>
                
                <div class="p-4 bg-gray-50 rounded border">
                    <label class="block text-sm font-bold mb-2">🎁 Icon Hadiah (Reward)</label>
                    <input type="file" name="reward_img" required class="w-full text-sm">
                    <p class="text-xs text-gray-400 mt-1">Format: PNG (Transparan) disarankan.</p>
                </div>

                <div class="p-4 bg-gray-50 rounded border">
                    <label class="block text-sm font-bold mb-2">🎨 Background Pattern</label>
                    <input type="file" name="bg_pattern_img" required class="w-full text-sm">
                    <p class="text-xs text-gray-400 mt-1">Icon kecil warna putih/transparan untuk hiasan.</p>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold mb-1">Misi Utama</label>
                    <textarea name="mission" required class="w-full border p-2 rounded h-20" placeholder="Contoh: Posting 2 konten tiktok..."></textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-bold mb-1">Syarat & Ketentuan</label>
                    <textarea name="syarat" required class="w-full border p-2 rounded h-28 bg-yellow-50 focus:bg-white transition" placeholder="Minimal durasi 15 detik&#10;Wajib tag akun admin&#10;Akun tidak diprivate"></textarea>
                    <p class="text-xs text-red-500 mt-1 font-semibold">*Pisahkan setiap poin syarat dengan tombol ENTER.</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold mb-1">Warna Utama</label>
                        <input type="color" name="color_primary" value="#4ade80" class="w-full h-10 cursor-pointer rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-1">Warna Aksen</label>
                        <input type="color" name="color_accent" value="#16a34a" class="w-full h-10 cursor-pointer rounded">
                    </div>
                </div>
            </div>

            <div class="col-span-1 md:col-span-2 flex gap-3 mt-4 pt-4 border-t">
                <button type="submit" name="simpan" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 font-bold w-full shadow-lg transform active:scale-95 transition">
                    Simpan Event
                </button>
                <a href="index.php" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 font-bold w-1/3 text-center">
                    Batal
                </a>
            </div>

        </form>
    </div>
</body>
</html>

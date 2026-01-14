<?php
session_start();
include '../../db/koneksi.php';


if (isset($_POST['simpan'])) {
    $title      = $_POST['title'];
    $urutan     = $_POST['urutan'];
    $mission    = $_POST['mission'];
    $syarat     = $_POST['syarat'];
    $ai_prompt  = $_POST['ai_prompt']; // <--- INPUT BARU
    $video_limit= $_POST['video_limit']; // <--- INPUT BARU
    $reward_img = $_POST['reward_img'];
    $bg_pattern = $_POST['bg_pattern_img'];
    $color_pri  = $_POST['color_primary'];
    $color_acc  = $_POST['color_accent'];

    // QUERY INSERT BARU
    $sql = "INSERT INTO events (title, urutan, mission, syarat, ai_prompt, video_limit, reward_img, bg_pattern_img, color_primary, color_accent) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $urutan, $mission, $syarat, $ai_prompt, $video_limit, $reward_img, $bg_pattern, $color_pri, $color_acc]);

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
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-4xl">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-4">➕ Tambah Event Baru</h2>
        
        <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold mb-1">Judul Event</label>
                    <input type="text" name="title" required class="w-full border p-2 rounded" placeholder="Contoh: Lomba Makan Kerupuk">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold mb-1">Urutan</label>
                        <input type="number" name="urutan" value="1" class="w-full border p-2 rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-1">Limit Video</label>
                        <select name="video_limit" class="w-full border p-2 rounded bg-white">
                            <option value="1">1 Video</option>
                            <option value="2">2 Video</option>
                            <option value="3">3 Video</option>
                            <option value="4">4 Video</option>
                            <option value="5">5 Video</option>
                        </select>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-bold mb-1">Link Gambar Icon (Hadiah)</label>
                    <input type="url" name="reward_img" required class="w-full border p-2 rounded text-sm" placeholder="https://...">
                </div>
                <div>
                    <label class="block text-sm font-bold mb-1">Link Background Pattern</label>
                    <input type="url" name="bg_pattern_img" required class="w-full border p-2 rounded text-sm" placeholder="https://...">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold mb-1">Warna Utama</label>
                        <input type="color" name="color_primary" value="#0E5941" class="w-full h-10 cursor-pointer rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-1">Warna Aksen</label>
                        <input type="color" name="color_accent" value="#17FFB2" class="w-full h-10 cursor-pointer rounded">
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold mb-1">Misi Singkat (Untuk Manusia)</label>
                    <textarea name="mission" required class="w-full border p-2 rounded h-20" placeholder="Contoh: Upload video kamu sedang makan kerupuk..."></textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-bold mb-1">Syarat & Ketentuan</label>
                    <textarea name="syarat" required class="w-full border p-2 rounded h-24 bg-yellow-50" placeholder="Pisahkan dengan ENTER per poin..."></textarea>
                </div>

                <div class="bg-purple-50 p-4 rounded border border-purple-200">
                    <label class="block text-sm font-bold mb-1 text-purple-700">🤖 Perintah untuk AI (Prompt)</label>
                    <textarea name="ai_prompt" required class="w-full border p-2 rounded h-28 text-sm" placeholder="Contoh: Video harus menampilkan seseorang yang sedang makan kerupuk yang digantung. Latar belakang harus terang."></textarea>
                    <p class="text-xs text-gray-500 mt-1">Jelaskan secara detail apa yang harus dilihat AI agar video dianggap VALID.</p>
                </div>
            </div>

            <div class="col-span-1 md:col-span-2 flex gap-3 mt-4 pt-4 border-t">
                <button type="submit" name="simpan" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 font-bold w-full shadow-lg">
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

<?php
session_start();
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: index.php");
    exit;
}
include '../../db/koneksi.php';

// Cek ID
if (!isset($_GET['id'])) {
    header("location:index.php");
    exit();
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
$stmt->execute([$id]);
$data = $stmt->fetch();

if (!$data) {
    header("location:index.php");
    exit();
}

// PROSES UPDATE
if (isset($_POST['update'])) {
    $title      = $_POST['title'];
    $urutan     = $_POST['urutan'];
    $mission    = $_POST['mission'];
    $syarat     = $_POST['syarat'];
    $ai_prompt  = $_POST['ai_prompt']; // <--- UPDATE KOLOM AI
    $video_limit= $_POST['video_limit']; // <--- UPDATE KOLOM LIMIT
    $reward_img = $_POST['reward_img'];
    $bg_pattern = $_POST['bg_pattern_img'];
    $color_pri  = $_POST['color_primary'];
    $color_acc  = $_POST['color_accent'];

    $sql = "UPDATE events SET 
            title=?, urutan=?, mission=?, syarat=?, ai_prompt=?, video_limit=?, 
            reward_img=?, bg_pattern_img=?, 
            color_primary=?, color_accent=? 
            WHERE id=?";
            
    $update = $pdo->prepare($sql);
    $update->execute([$title, $urutan, $mission, $syarat, $ai_prompt, $video_limit, $reward_img, $bg_pattern, $color_pri, $color_acc, $id]);

    header("location:index.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Event</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-10">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-4xl">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-4">✏️ Edit Event: <?= htmlspecialchars($data['title']) ?></h2>
        
        <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold mb-1">Judul Event</label>
                    <input type="text" name="title" value="<?= htmlspecialchars($data['title']) ?>" required class="w-full border p-2 rounded">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold mb-1">Urutan</label>
                        <input type="number" name="urutan" value="<?= $data['urutan'] ?>" class="w-full border p-2 rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-1">Limit Video</label>
                        <select name="video_limit" class="w-full border p-2 rounded bg-white">
                            <?php for($i=1; $i<=5; $i++): ?>
                                <option value="<?= $i ?>" <?= $data['video_limit'] == $i ? 'selected' : '' ?>><?= $i ?> Video</option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-bold mb-1">Link Icon Hadiah</label>
                    <input type="url" name="reward_img" value="<?= htmlspecialchars($data['reward_img']) ?>" required class="w-full border p-2 rounded text-sm">
                </div>
                <div>
                    <label class="block text-sm font-bold mb-1">Link Background Pattern</label>
                    <input type="url" name="bg_pattern_img" value="<?= htmlspecialchars($data['bg_pattern_img']) ?>" required class="w-full border p-2 rounded text-sm">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold mb-1">Warna Utama</label>
                        <input type="color" name="color_primary" value="<?= $data['color_primary'] ?>" class="w-full h-10 cursor-pointer rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-1">Warna Aksen</label>
                        <input type="color" name="color_accent" value="<?= $data['color_accent'] ?>" class="w-full h-10 cursor-pointer rounded">
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold mb-1">Misi Utama</label>
                    <textarea name="mission" required class="w-full border p-2 rounded h-20"><?= htmlspecialchars($data['mission']) ?></textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-bold mb-1">Syarat & Ketentuan</label>
                    <textarea name="syarat" required class="w-full border p-2 rounded h-24 bg-yellow-50"><?= htmlspecialchars($data['syarat']) ?></textarea>
                </div>

                <div class="bg-purple-50 p-4 rounded border border-purple-200">
                    <label class="block text-sm font-bold mb-1 text-purple-700">🤖 Perintah untuk AI (Prompt)</label>
                    <textarea name="ai_prompt" required class="w-full border p-2 rounded h-28 text-sm"><?= htmlspecialchars($data['ai_prompt'] ?? '') ?></textarea>
                    <p class="text-xs text-gray-500 mt-1">Ubah kalimat ini untuk mengganti cara AI menilai video.</p>
                </div>
            </div>

            <div class="col-span-1 md:col-span-2 flex gap-3 mt-4 pt-4 border-t">
                <button type="submit" name="update" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 font-bold w-full shadow-lg">
                    Simpan Perubahan
                </button>
                <a href="index.php" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 font-bold w-1/3 text-center">
                    Batal
                </a>
            </div>

        </form>
    </div>
</body>
</html>

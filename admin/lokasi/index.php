<?php
session_start();
include '../../db/koneksi.php';
// 2. PROSES UPDATE DATA
if (isset($_POST['update'])) {
    $nama       = $_POST['nama_tempat'];
    $deskripsi  = $_POST['deskripsi'];
    $alamat     = $_POST['alamat'];
    $gmaps      = $_POST['link_google_maps'];
    $embed      = $_POST['link_embed_maps'];

    // Kita selalu update ID = 1 karena lokasinya cuma satu
    $sql = "UPDATE lokasi SET nama_tempat=?, deskripsi=?, alamat=?, link_google_maps=?, link_embed_maps=? WHERE id=1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nama, $deskripsi, $alamat, $gmaps, $embed]);

    $sukses = "Data lokasi berhasil diperbarui!";
}

// 3. AMBIL DATA SAAT INI (ID = 1)
$stmt = $pdo->query("SELECT * FROM lokasi WHERE id = 1");
$data = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Kelola Lokasi - CMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 p-6 flex justify-center min-h-screen">
    <div class="w-full max-w-5xl">
        
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">📍 Atur Info Lokasi</h1>
            <a href="../index.php" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                <i class="fas fa-arrow-left"></i> Kembali Dashboard
            </a>
        </div>

        <?php if(isset($sukses)): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <i class="fas fa-check-circle"></i> <?= $sukses ?>
        </div>
        <?php endif; ?>

        <div class="bg-white rounded-xl shadow-md p-8">
            <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <div class="space-y-4">
                    <h3 class="font-bold text-lg text-gray-700 border-b pb-2">Informasi Dasar</h3>
                    
                    <div>
                        <label class="block text-sm font-bold mb-1">Nama Tempat Wisata</label>
                        <input type="text" name="nama_tempat" value="<?= htmlspecialchars($data['nama_tempat']) ?>" class="w-full border p-2 rounded focus:ring-2 focus:ring-green-400">
                    </div>

                    <div>
                        <label class="block text-sm font-bold mb-1">Deskripsi Singkat</label>
                        <textarea name="deskripsi" class="w-full border p-2 rounded h-32"><?= htmlspecialchars($data['deskripsi']) ?></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-bold mb-1">Alamat Lengkap</label>
                        <textarea name="alamat" class="w-full border p-2 rounded h-24 bg-gray-50"><?= htmlspecialchars($data['alamat']) ?></textarea>
                    </div>
                </div>

                <div class="space-y-4">
                    <h3 class="font-bold text-lg text-gray-700 border-b pb-2">Konfigurasi Maps</h3>

                    <div class="bg-blue-50 p-4 rounded text-sm text-blue-800 mb-4">
                        <strong>Cara ambil Link Embed:</strong><br>
                        Buka Google Maps -> Pilih Lokasi -> Klik "Bagikan" (Share) -> Pilih "Sematkan Peta" (Embed) -> Salin HTML -> Ambil isinya <code>src="..."</code> saja.
                    </div>

                    <div>
                        <label class="block text-sm font-bold mb-1">Link Embed Maps (Iframe SRC)</label>
                        <input type="text" name="link_embed_maps" value="<?= htmlspecialchars($data['link_embed_maps']) ?>" class="w-full border p-2 rounded text-sm text-purple-600 break-all" placeholder="https://www.google.com/maps/embed?pb=...">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold mb-1">Link Tombol Navigasi</label>
                        <input type="url" name="link_google_maps" value="<?= htmlspecialchars($data['link_google_maps']) ?>" class="w-full border p-2 rounded text-sm text-blue-600" placeholder="https://maps.app.goo.gl/...">
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-bold mb-2">Preview Peta Saat Ini:</label>
                        <div class="w-full h-48 bg-gray-200 rounded overflow-hidden border">
                            <iframe src="<?= $data['link_embed_maps'] ?>" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    </div>
                </div>

                <div class="col-span-1 md:col-span-2 border-t pt-6 mt-2">
                    <button type="submit" name="update" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-lg shadow-lg transition transform active:scale-95">
                        💾 Simpan Perubahan Lokasi
                    </button>
                </div>

            </form>
        </div>
    </div>
</body>
</html>

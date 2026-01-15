<?php
include 'db/koneksi.php';
$message = "";
$ticket_data = null;

// Jika Panitia Scan/Submit Kode
if (isset($_POST['check_code'])) {
    $input_code = mysqli_real_escape_string($conn, $_POST['code']);
    
    // Cari Kode di DB
    $query = "SELECT * FROM tickets WHERE kode_unik = '$input_code'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $ticket_data = mysqli_fetch_assoc($result);
    } else {
        $message = "<div class='bg-red-100 text-red-700 p-4 rounded-xl font-bold mb-4 text-center'>❌ KODE TIDAK DITEMUKAN / PALSU!</div>";
    }
}

// Jika Panitia Klik Tombol "Berikan Hadiah" (Finalisasi)
if (isset($_POST['claim_reward'])) {
    $claim_code = mysqli_real_escape_string($conn, $_POST['claim_code']);
    
    // Update status jadi USED
    $update = "UPDATE tickets SET status = 'used', waktu_klaim = NOW() WHERE kode_unik = '$claim_code'";
    if (mysqli_query($conn, $update)) {
        $message = "<div class='bg-green-100 text-green-700 p-4 rounded-xl font-bold mb-4 text-center animate-bounce'>✅ BERHASIL! HADIAH TELAH DIBERIKAN.</div>";
    } else {
        $message = "Error DB.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Verifikasi Tiket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@500;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Fredoka', sans-serif; background: #f0fdf4; }</style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden border-4 border-green-500">
        <div class="bg-green-600 p-6 text-center">
            <h1 class="text-white text-2xl font-black uppercase">👮‍♂️ Panitia Gate</h1>
            <p class="text-green-200 text-sm">Verifikasi Keaslian Voucher</p>
        </div>

        <div class="p-6">
            <?= $message ?>

            <form method="POST" class="mb-6">
                <label class="block text-gray-500 text-sm font-bold mb-2">MASUKKAN KODE UNIK:</label>
                <div class="flex gap-2">
                    <input type="text" name="code" class="w-full border-2 border-gray-300 rounded-xl px-4 py-3 text-xl font-mono uppercase font-bold focus:border-green-500 outline-none" placeholder="TIKET-XXXX-XXXX" required value="<?= isset($_POST['code']) ? $_POST['code'] : '' ?>">
                    <button type="submit" name="check_code" class="bg-blue-600 text-white px-6 rounded-xl font-bold hover:bg-blue-700">CEK</button>
                </div>
            </form>

            <hr class="border-dashed border-gray-300 my-6">

            <?php if ($ticket_data): ?>
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                    <div class="text-center mb-4">
                        <p class="text-gray-400 text-xs uppercase">Pemilik Tiket</p>
                        <h2 class="text-2xl font-black text-gray-800"><?= $ticket_data['nama_peserta'] ?></h2>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
                        <div>
                            <p class="text-gray-400 text-xs">Misi</p>
                            <p class="font-bold text-gray-700"><?= $ticket_data['misi'] ?></p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-xs">Dibuat</p>
                            <p class="font-bold text-gray-700"><?= date('H:i d/m', strtotime($ticket_data['waktu_dibuat'])) ?></p>
                        </div>
                    </div>

                    <div class="text-center">
                        <?php if ($ticket_data['status'] == 'unused'): ?>
                            
                            <div class="bg-green-100 text-green-700 px-4 py-2 rounded-full font-black inline-block mb-4 text-lg border-2 border-green-500">
                                ✨ VALID - BELUM DIPAKAI
                            </div>
                            
                            <form method="POST">
                                <input type="hidden" name="claim_code" value="<?= $ticket_data['kode_unik'] ?>">
                                <button type="submit" name="claim_reward" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-4 rounded-xl text-xl shadow-lg transform active:scale-95 transition">
                                    🎁 BERIKAN HADIAH
                                </button>
                            </form>

                        <?php else: ?>
                            
                            <div class="bg-red-100 text-red-600 px-4 py-2 rounded-full font-black inline-block mb-2 text-lg border-2 border-red-500">
                                ⚠️ SUDAH DIPAKAI!
                            </div>
                            <p class="text-red-500 text-sm font-bold">
                                Diklaim pada: <?= date('d M Y, H:i', strtotime($ticket_data['waktu_klaim'])) ?>
                            </p>
                            <p class="text-gray-400 text-xs mt-2">Jangan berikan hadiah lagi.</p>

                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>

</body>

</html>

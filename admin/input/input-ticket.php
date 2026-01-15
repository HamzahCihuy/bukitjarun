<?php
session_start();

// Cek Login Admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../../admin/login.php"); 
    exit;
}

// 1. KONEKSI DATABASE (Mundur 2 langkah)
if (file_exists('../../db/koneksi.php')) { 
    include '../../db/koneksi.php'; 
} elseif (file_exists('../../../db/koneksi.php')) { 
    include '../../../db/koneksi.php'; 
} else { 
    die("Koneksi database tidak ditemukan."); 
}

$message = "";
$ticket_data = null;

// 2. LOGIKA CEK KODE (PANITIA SCAN)
if (isset($_POST['check_code'])) {
    // Bersihkan input
    $input_code = preg_replace('/[^a-zA-Z0-9-]/', '', $_POST['code']);
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM tickets WHERE kode_unik = ?");
        $stmt->execute([$input_code]);
        $ticket_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$ticket_data) {
            $message = "<div class='bg-red-100 text-red-700 p-4 rounded-xl font-bold mb-4 text-center border border-red-400'>❌ KODE TIDAK DITEMUKAN!</div>";
        }
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}

// 3. LOGIKA KLAIM HADIAH / GANTI STATUS KE 'USED'
if (isset($_POST['claim_reward'])) {
    $claim_code = $_POST['claim_code'];
    
    try {
        // UPDATE STATUS JADI 'used'
        $stmt = $pdo->prepare("UPDATE tickets SET status = 'used' WHERE kode_unik = ?");
        
        if ($stmt->execute([$claim_code])) {
            $message = "<div class='bg-green-100 text-green-700 p-4 rounded-xl font-bold mb-4 text-center animate-bounce border border-green-400'>✅ BERHASIL! STATUS TIKET SEKARANG 'USED'.</div>";
            
            // Refresh data
            $stmt = $pdo->prepare("SELECT * FROM tickets WHERE kode_unik = ?");
            $stmt->execute([$claim_code]);
            $ticket_data = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        $message = "Error DB: " . $e->getMessage();
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
        
        <div class="bg-green-600 p-6 text-center relative">
            <a href="../../admin/index.php" class="absolute left-4 top-1/2 -translate-y-1/2 text-white/80 hover:text-white text-sm font-bold">← Back</a>
            <h1 class="text-white text-2xl font-black uppercase">👮‍♂️ Panitia Gate</h1>
            <p class="text-green-200 text-sm">Cek Status: Used / Unused</p>
        </div>

        <div class="p-6">
            <?= $message ?>

            <form method="POST" class="mb-6">
                <label class="block text-gray-500 text-sm font-bold mb-2">MASUKKAN KODE UNIK:</label>
                <div class="flex gap-2">
                    <input type="text" name="code" class="w-full border-2 border-gray-300 rounded-xl px-4 py-3 text-xl font-mono uppercase font-bold focus:border-green-500 outline-none text-center" 
                           placeholder="000000" maxlength="6" required 
                           value="<?= isset($_POST['code']) ? htmlspecialchars($_POST['code']) : '' ?>">
                    <button type="submit" name="check_code" class="bg-blue-600 text-white px-6 rounded-xl font-bold hover:bg-blue-700 shadow-lg">CEK</button>
                </div>
            </form>

            <hr class="border-dashed border-gray-300 my-6">

            <?php if ($ticket_data): ?>
                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200 shadow-inner">
                    <div class="text-center mb-6">
                        <p class="text-gray-400 text-xs uppercase font-bold tracking-widest">Pemilik Tiket</p>
                        <h2 class="text-3xl font-black text-gray-800 leading-tight"><?= htmlspecialchars($ticket_data['nama_peserta']) ?></h2>
                        <p class="text-sm text-gray-500 mt-1 font-mono"><?= htmlspecialchars($ticket_data['no_hp']) ?></p>
                    </div>

                    <div class="bg-white p-4 rounded-xl border border-gray-100 mb-6">
                        <div class="flex justify-between items-center mb-2 border-b border-gray-100 pb-2">
                            <span class="text-gray-400 text-xs font-bold uppercase">Misi Selesai</span>
                            <span class="font-bold text-gray-700 text-right text-sm"><?= htmlspecialchars($ticket_data['misi']) ?></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-xs font-bold uppercase">Tanggal Dibuat</span>
                            <span class="font-bold text-gray-700 text-sm"><?= date('d M Y, H:i', strtotime($ticket_data['waktu_dibuat'])) ?></span>
                        </div>
                    </div>

                    <div class="text-center">
                        
                        <?php if ($ticket_data['status'] == 'unused' || $ticket_data['status'] == 'active'): ?> 
                            <div class="bg-green-100 text-green-700 px-6 py-2 rounded-full font-black inline-block mb-6 text-sm border border-green-300 shadow-sm animate-pulse uppercase">
                                ✨ Status: UNUSED (Aman)
                            </div>
                            
                            <form method="POST" onsubmit="return confirm('Yakin ingin menukarkan tiket ini? Status akan berubah jadi USED.');">
                                <input type="hidden" name="claim_code" value="<?= htmlspecialchars($ticket_data['kode_unik']) ?>">
                                <input type="hidden" name="code" value="<?= htmlspecialchars($ticket_data['kode_unik']) ?>"> 
                                <input type="hidden" name="check_code" value="1">
                                
                                <button type="submit" name="claim_reward" class="w-full bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold py-4 rounded-xl text-xl shadow-xl transform active:scale-95 transition flex items-center justify-center gap-2">
                                    <span>🎁 TUKARKAN (SET USED)</span>
                                </button>
                            </form>

                        <?php else: ?>
                            
                            <div class="bg-red-100 text-red-600 px-6 py-2 rounded-full font-black inline-block mb-4 text-sm border border-red-300 uppercase">
                                ⚠️ Status: USED (Sudah Dipakai)
                            </div>
                            
                            <div class="bg-white p-3 rounded-lg border border-red-100 text-center">
                                <p class="text-xs text-gray-400 uppercase font-bold">Data Database</p>
                                <p class="text-red-500 font-bold text-lg uppercase"><?= $ticket_data['status'] ?></p>
                            </div>
                            
                            <p class="text-gray-400 text-xs mt-4 italic font-bold">⛔ JANGAN BERIKAN HADIAH LAGI.</p>

                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>

</body>
</html>

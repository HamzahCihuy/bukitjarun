<?php
// send_wa.php - Versi Dinamis (Database)

function kirimPesanFonnte($target, $pesan) {
    global $pdo; // Ambil koneksi dari luar

    // 1. COBA AMBIL TOKEN DARI DATABASE
    $token = "";
    if ($pdo) {
        try {
            $stmt = $pdo->prepare("SELECT setting_value FROM settings WHERE setting_key = 'fonnte_token'");
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($data) {
                $token = $data['setting_value'];
            }
        } catch (Exception $e) {
            // Abaikan error db, lanjut cek env
        }
    }

    // 2. JIKA DATABASE KOSONG, AMBIL DARI RAILWAY (FALLBACK)
    if (empty($token)) {
        $token = getenv('FONNTE_TOKEN'); 
    }

    // LOGGING
    if (!$token) {
        error_log("❌ ERROR: Token Fonnte Kosong (Di DB & Env tidak ada).");
        return false;
    }

    // --- PROSES KIRIM (SAMA SEPERTI SEBELUMNYA) ---
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.fonnte.com/send',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => array(
        'target' => $target,
        'message' => $pesan,
        'countryCode' => '62', 
      ),
      CURLOPT_HTTPHEADER => array(
        "Authorization: $token"
      ),
    ));

    $response = curl_exec($curl);
    if (curl_errno($curl)) {
        error_log("❌ WA ERROR: " . curl_error($curl));
    } else {
        error_log("✅ WA SENT: " . $response);
    }
    curl_close($curl);
    
    return $response;
}
?>

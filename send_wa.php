<?php
function kirimPesanFonnte($target, $pesan) {
    // 1. Ambil Token
    $token = "yDafQ7Nis41SGtVcVsThNx7UpoyXuapHT7M9gL";

    // LOGGING 1: Cek apakah token terbaca?
    if (!$token) {
        error_log("❌ ERROR WA: Token FONNTE_TOKEN kosong/tidak terbaca di Railway!");
        return false;
    }

    // LOGGING 2: Cek mau kirim kemana?
    error_log("🚀 MENGIRIM WA KE: " . $target);

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.fonnte.com/send',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0, // Tunggu sampai selesai
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
    
    // LOGGING 3: Apa balasan dari Fonnte?
    if (curl_errno($curl)) {
        error_log("❌ CURL ERROR: " . curl_error($curl));
    } else {
        error_log("✅ BALASAN FONNTE: " . $response);
    }

    curl_close($curl);
    
    return $response;
}
?>

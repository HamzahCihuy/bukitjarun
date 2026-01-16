<?php
function kirimPesanFonnte($target, $pesan) {
    // GANTI TOKEN INI DENGAN TOKEN DARI DASHBOARD FONNTE KAMU
    $token = getenv('FWA_API'); 

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
        'countryCode' => '62', // Otomatis ubah 08 jadi 62
      ),
      CURLOPT_HTTPHEADER => array(
        "Authorization: $token"
      ),
    ));

    $response = curl_exec($curl);
    
    // Kita tidak perlu menunggu respon detail, tutup saja agar cepat
    curl_close($curl);
    
    return $response;
}
?>

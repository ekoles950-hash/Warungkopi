<?php
$user_id  = "ekolestiyo"; 
$pin_qios = "123456"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nomor = trim($_POST['nomor_hp']);
    $sku   = trim($_POST['sku']);
    $ref   = 'GRAB' . date('His');
    
    $url = "https://qiospay.id/api/h2h/trx"; 
    
    $payload = [
        'user_id' => $user_id,
        'pin'     => $pin_qios,
        'nomor'   => $nomor,
        'produk'  => $sku,
        'm_reff'  => $ref
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    // INI BEDANYA: Kirim sebagai JSON, bukan form biasa
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload)); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    
    $response = curl_exec($ch);
    $hasil = json_decode($response, true);
    curl_close($ch);

    echo "<!DOCTYPE html><html><head><meta name='viewport' content='width=device-width, initial-scale=1.0'><script src='https://cdn.tailwindcss.com'></script></head>
    <body class='bg-white flex items-center justify-center min-h-screen p-4 font-sans'>";
    
    echo "<div class='w-full max-w-md bg-white border border-slate-200 rounded-xl p-6 shadow-sm'>";
    
    if ($response) {
        // Tampilkan jawaban ASLI dari server Qiospay biar Mas percaya
        echo "<h2 class='text-xs font-bold mb-2 text-slate-400'>RESPON ASLI DARI QIOSPAY:</h2>";
        echo "<pre class='text-[12px] text-yellow-600 bg-slate-900 p-4 rounded-lg overflow-auto font-mono'>";
        echo htmlspecialchars($response);
        echo "</pre>";
        
        echo "<button onclick='window.location.href=\"/\"' class='w-full mt-4 py-3 bg-blue-600 text-white rounded-lg font-bold text-sm'>COBA LAGI</button>";
    } else {
        echo "<p class='text-red-500'>Tidak ada respon dari server Qiospay. Cek IP di panel.</p>";
    }

    echo "</div></body></html>";
}
?>
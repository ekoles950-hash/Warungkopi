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
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload)); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    
    $response = curl_exec($ch);
    curl_close($ch);

    echo "<!DOCTYPE html><html><head><meta name='viewport' content='width=device-width, initial-scale=1.0'><script src='https://cdn.tailwindcss.com'></script></head>
    <body class='bg-slate-100 flex items-center justify-center min-h-screen p-4 font-sans'>";
    
    echo "<div class='w-full max-w-md bg-white border border-slate-200 rounded-xl p-6 shadow-sm'>";
    
    // TAMPILKAN DATA YANG DIKIRIM (CEK DI SINI MAS!)
    echo "<h2 class='text-[10px] font-bold mb-2 text-blue-500 uppercase'>Data yang Mas Kirim:</h2>";
    echo "<div class='bg-blue-50 p-3 rounded-lg border border-blue-100 mb-4 text-[11px] font-mono text-blue-800'>";
    echo "ID: $user_id | PIN: $pin_qios | SKU: $sku | NO: $nomor";
    echo "</div>";

    // TAMPILKAN JAWABAN ASLI QIOSPAY
    echo "<h2 class='text-[10px] font-bold mb-2 text-slate-400 uppercase'>Jawaban Asli Qiospay:</h2>";
    echo "<div class='bg-slate-900 p-4 rounded-lg font-mono text-[12px] text-yellow-500 mb-4'>";
    echo $response ? htmlspecialchars($response) : "KOSONG (Server Mati)";
    echo "</div>";
    
    echo "<button onclick='window.location.href=\"/\"' class='w-full py-3 bg-slate-200 text-slate-700 rounded-lg font-bold text-sm'>KEMBALI</button>";
    echo "</div></body></html>";
}
?>
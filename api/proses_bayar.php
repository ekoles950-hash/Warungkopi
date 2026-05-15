<?php
$user_id  = "ekolestiyo"; 
$pin_qios = 123456; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Kita bersihkan spasi yang nggak sengaja ketik (trim)
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
    // Balik ke http_build_query (format form)
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload)); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $response = curl_exec($ch);
    $hasil = json_decode($response, true);
    curl_close($ch);

    echo "<!DOCTYPE html><html><head><meta name='viewport' content='width=device-width, initial-scale=1.0'><script src='https://cdn.tailwindcss.com'></script></head>
    <body class='bg-slate-900 text-white flex items-center justify-center min-h-screen p-6 font-sans'>";
    echo "<div class='bg-slate-800 p-8 rounded-3xl border border-slate-700 text-center w-full max-w-sm shadow-2xl'>";
    
    if (isset($hasil['status']) && ($hasil['status'] == 'success' || $hasil['status'] == 'PENDING')) {
        echo "<h2 class='text-green-500 font-black text-xl uppercase italic'>SUKSES!</h2>";
        echo "<p class='text-xs mt-2'>".$hasil['message']."</p>";
    } else {
        echo "<h2 class='text-yellow-500 font-bold uppercase mb-2 text-sm'>STATUS TRANSAKSI</h2>";
        echo "<div class='bg-black p-4 rounded-xl text-left border border-slate-700'>";
        echo "<p class='text-[10px] text-yellow-500 font-mono'>RESPON: " . ($response ? htmlspecialchars($response) : "Qiospay Menolak (Cek IP)") . "</p>";
        echo "</div>";
        echo "<p class='text-[9px] text-slate-500 mt-4 italic'>Mencoba SKU: $sku ke $nomor</p>";
    }
    echo "<button onclick='window.location.href=\"/\"' class='bg-blue-600 w-full py-4 rounded-2xl font-black mt-6 text-xs uppercase tracking-widest'>Kembali</button></div></body></html>";
}
?>
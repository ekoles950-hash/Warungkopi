<?php
// Pastikan User ID dan PIN murni tanpa spasi
$user_id  = "ekolestiyo"; 
$pin_qios = "123456"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Trim untuk hapus spasi yang nggak sengaja ketik
    $nomor_tujuan = trim($_POST['nomor_hp']);
    $kode_produk  = trim($_POST['sku']);
    $ref_id       = 'GRAB' . date('His');
    
    $url = "https://qiospay.id/api/h2h/trx"; 
    
    // Payload dengan nama variabel standar Qiospay
    $payload = [
        'user_id' => $user_id,
        'pin'     => $pin_qios,
        'nomor'   => $nomor_tujuan,
        'produk'  => $kode_produk,
        'm_reff'  => $ref_id
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload)); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    // INI RAHASIANYA: Kirim header seperti aplikasi
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
    
    $response = curl_exec($ch);
    $hasil = json_decode($response, true);
    curl_close($ch);

    echo "<!DOCTYPE html><html><head><meta name='viewport' content='width=device-width, initial-scale=1.0'><script src='https://cdn.tailwindcss.com'></script></head>
    <body class='bg-slate-50 text-slate-900 flex items-center justify-center min-h-screen p-4 font-sans'>";
    
    echo "<div class='w-full max-w-md bg-white border border-slate-200 rounded-2xl p-6 shadow-xl'>";
    
    if ($hasil) {
        // Tampilkan format JSON persis seperti screenshot BukaOlshop Mas
        echo "<h2 class='text-sm font-bold mb-4 text-slate-400 uppercase tracking-widest'>Response Data</h2>";
        echo "<pre class='text-[11px] text-slate-700 bg-slate-900 text-yellow-500 p-4 rounded-xl border border-slate-800 overflow-auto leading-relaxed font-mono'>";
        echo json_encode($hasil, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        echo "</pre>";
        
        echo "<button onclick='window.location.href=\"/\"' class='w-full mt-6 py-4 bg-blue-600 text-white rounded-xl font-black text-sm shadow-lg shadow-blue-200 uppercase'>Selesai</button>";
    } else {
        echo "<div class='text-center py-6'>";
        echo "<div class='text-red-500 font-black text-xl mb-2'>ERROR RESPONSE</div>";
        echo "<p class='text-xs text-slate-400 mb-4'>Qiospay menjawab: <span class='text-red-400 font-bold'>".htmlspecialchars($response)."</span></p>";
        echo "<button onclick='window.location.href=\"/\"' class='w-full mt-4 py-4 bg-slate-100 text-slate-600 rounded-xl font-bold text-sm uppercase tracking-widest'>Kembali ke Depan</button>";
        echo "</div>";
    }

    echo "</div></body></html>";
}
?>
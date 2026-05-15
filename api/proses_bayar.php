<?php
$user_id  = "ekolestiyo"; 
$pin_qios = "1234"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nomor = $_POST['nomor_hp'];
    $sku   = $_POST['sku'];
    $ref   = 'GRAB' . date('His');
    
    // Ambil IP Vercel yang sedang dipakai saat ini
    $ip_saya = file_get_contents('https://api.ipify.org');

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
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $response = curl_exec($ch);
    $hasil = json_decode($response, true);
    curl_close($ch);

    echo "<!DOCTYPE html><html><head><meta name='viewport' content='width=device-width, initial-scale=1.0'><script src='https://cdn.tailwindcss.com'></script></head>
    <body class='bg-slate-900 text-white flex items-center justify-center min-h-screen p-6'>
    <div class='bg-slate-800 p-8 rounded-3xl border border-slate-700 text-center w-full max-w-sm shadow-2xl'>";
    
    if (isset($hasil['status']) && $hasil['status'] == 'success') {
        echo "<h2 class='text-green-500 font-black text-xl uppercase mb-2'>Berhasil!</h2>";
    } else {
        $msg = $hasil['message'] ?? 'Respon Server Kosong';
        echo "<h2 class='text-yellow-500 font-bold uppercase mb-2'>Gagal</h2>";
        echo "<div class='bg-slate-900 p-4 rounded-xl border border-slate-700 mb-4'>";
        echo "<p class='text-xs text-slate-400'>Pesan: $msg</p>";
        echo "</div>";
        
        // TAMPILKAN IP VERCEL MAS DI SINI
        echo "<div class='bg-blue-900/30 p-3 rounded-lg border border-blue-500 mb-4'>";
        echo "<p class='text-[10px] text-blue-300 font-bold mb-1'>IP VERCEL MAS SAAT INI:</p>";
        echo "<p class='text-lg font-mono text-white tracking-widest'>$ip_saya</p>";
        echo "</div>";
        echo "<p class='text-[8px] text-slate-500'>Salin IP di atas ke panel Qiospay!</p>";
    }
    echo "<button onclick='window.location.href=\"/\"' class='bg-blue-600 w-full py-4 rounded-2xl font-black mt-6 text-[10px] uppercase'>Kembali</button></div></body></html>";
}
?>
<?php
$user_id  = "ekolestiyo"; 
$pin_qios = "123456"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nomor = $_POST['nomor_hp'];
    $sku   = $_POST['sku'];
    $ref   = 'GRAB' . date('His');

    $url = "https://qiospay.id/api/h2h/trx"; 
    
    // Kita pakai format ARRAY untuk CURL agar lebih stabil seperti aplikasi
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
    // Tambahkan User Agent agar server Qiospay menganggap ini akses resmi
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Linux; Android 10; Redmi Note 8)');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 45); // Kasih waktu lebih lama biar gak kosong
    
    $response = curl_exec($ch);
    $hasil = json_decode($response, true);
    curl_close($ch);

    echo "<!DOCTYPE html><html><head><meta name='viewport' content='width=device-width, initial-scale=1.0'><script src='https://cdn.tailwindcss.com'></script></head>
    <body class='bg-slate-900 text-white flex items-center justify-center min-h-screen p-6 font-sans'>";
    
    echo "<div class='bg-slate-800 p-8 rounded-3xl border border-slate-700 text-center w-full max-w-sm shadow-2xl'>";
    
    // Cek status PENDING atau SUKSES (seperti di screenshot BukaOlshop Mas)
    if (isset($hasil['status']) && ($hasil['status'] == 'success' || $hasil['status'] == 'PENDING' || $hasil['status'] == 'SUKSES')) {
        echo "<div class='bg-green-500/20 p-4 rounded-2xl mb-4 border border-green-500'>";
        echo "<h2 class='text-green-500 font-black text-xl uppercase italic'>PROSES...</h2>";
        echo "</div>";
        echo "<p class='text-xs text-slate-300'>Pesanan $sku sedang diproses ke <br><span class='text-white font-bold'>$nomor</span></p>";
        if(isset($hasil['sn'])) echo "<p class='text-[10px] text-green-400 mt-2'>SN: ".$hasil['sn']."</p>";
    } else {
        // Jika masih kosong, kita paksa keluarin pesan aslinya
        $msg = $hasil['message'] ?? 'Qiospay belum merespon (Cek IP di Panel)';
        echo "<h2 class='text-yellow-500 font-bold text-lg uppercase mb-2 italic'>Gagal</h2>";
        echo "<div class='bg-slate-900 p-4 rounded-xl border border-slate-700'>";
        echo "<p class='text-xs text-slate-400'>$msg</p>";
        echo "</div>";
    }

    echo "<p class='text-[9px] text-slate-600 mt-6 uppercase tracking-widest'>Ref: $ref</p>";
    echo "<button onclick='window.location.href=\"/\"' class='bg-blue-600 w-full py-4 rounded-2xl font-black mt-4 uppercase text-xs'>Kembali</button>";
    echo "</div></body></html>";
}
?>
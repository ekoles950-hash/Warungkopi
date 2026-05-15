<?php
$user_id  = "ekolestiyo"; 
$pin_qios = "123456"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nomor = trim($_POST['nomor_hp']);
    $sku   = trim($_POST['sku']);
    $ref   = 'GRAB' . date('His');
    
    $url = "https://qiospay.id/api/h2h/trx"; 
    
    // Sesuaikan variabel dengan standar H2H Qiospay
    $payload = [
        'user_id' => $user_id,
        'pin'     => $pin_qios,
        'nomor'   => $nomor,
        'produk'  => $sku, // Pastikan di index.php value-nya beneran GPY1
        'm_reff'  => $ref
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload)); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    
    $response = curl_exec($ch);
    $hasil = json_decode($response, true);
    curl_close($ch);

    echo "<!DOCTYPE html><html><head><meta name='viewport' content='width=device-width, initial-scale=1.0'><script src='https://cdn.tailwindcss.com'></script></head>
    <body class='bg-white text-black flex items-center justify-center min-h-screen p-4 font-sans'>";
    
    echo "<div class='w-full max-w-md bg-white border border-slate-200 rounded-xl p-6 shadow-sm'>";
    
    // Jika Qiospay membalas dengan data (seperti di screenshot Mas)
    if ($hasil) {
        echo "<pre class='text-[12px] text-slate-700 bg-slate-50 p-4 rounded-lg border border-slate-100 overflow-auto leading-relaxed'>";
        // Menampilkan JSON persis seperti screenshot BukaOlshop Mas
        echo json_encode($hasil, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        echo "</pre>";
        
        // Tombol Kembali ala Aplikasi
        echo "<button onclick='window.location.href=\"/\"' class='w-full mt-4 py-3 bg-blue-600 text-white rounded-lg font-bold text-sm'>OK</button>";
    } else {
        // Jika mental atau kosong
        echo "<div class='text-center py-10'>";
        echo "<p class='text-red-500 font-bold'>Gagal terhubung ke server Qiospay</p>";
        echo "<p class='text-[10px] text-slate-400 mt-2'>Respon: ".htmlspecialchars($response)."</p>";
        echo "<button onclick='window.location.href=\"/\"' class='w-full mt-6 py-3 bg-slate-200 text-slate-700 rounded-lg font-bold text-sm'>KEMBALI</button>";
        echo "</div>";
    }

    echo "</div></body></html>";
}
?>
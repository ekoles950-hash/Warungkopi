<?php
$user_id  = "ekolestiyo"; 
$pin_qios = 123456; // TANPA TANDA PETIK (Kirim sebagai angka murni)

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nomor = $_POST['nomor_hp'];
    $sku   = $_POST['sku'];
    $ref   = 'GRAB' . date('His');
    $url   = "https://qiospay.id/api/h2h/trx"; 
    
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
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $hasil = json_decode($response, true);

    echo "<!DOCTYPE html><html><head><meta name='viewport' content='width=device-width, initial-scale=1.0'><script src='https://cdn.tailwindcss.com'></script></head>
    <body class='bg-slate-900 text-white flex items-center justify-center min-h-screen p-6'>";
    echo "<div class='bg-slate-800 p-8 rounded-3xl border border-slate-700 text-center w-full max-w-sm shadow-2xl'>";
    
    if (isset($hasil['status']) && ($hasil['status'] == 'success' || $hasil['status'] == 'PENDING')) {
        echo "<h2 class='text-green-500 font-black text-xl uppercase'>SUKSES!</h2>";
        echo "<p class='text-xs mt-2'>".$hasil['message']."</p>";
    } else {
        echo "<h2 class='text-red-500 font-bold uppercase mb-2'>INFO ERROR</h2>";
        echo "<div class='bg-black p-4 rounded-xl text-left border border-slate-700'>";
        echo "<p class='text-[10px] text-slate-500 mb-1 font-mono'>HTTP CODE: $httpCode</p>";
        echo "<p class='text-[10px] text-yellow-500 font-mono'>RESPON: " . ($response ? htmlspecialchars($response) : "Qiospay Blokir IP Mas") . "</p>";
        echo "</div>";
        echo "<p class='text-[8px] text-slate-500 mt-4'>Pastikan di Panel Qiospay IP 3.93.184.101 sudah masuk dan password 'Banjarnegara' sudah di-klik SIMPAN.</p>";
    }
    echo "<button onclick='window.location.href=\"/\"' class='bg-blue-600 w-full py-4 rounded-2xl font-black mt-6 text-xs uppercase'>Coba Lagi</button></div></body></html>";
}
?>
<?php
$user_id  = "OK2302353"; 
$pin_oke  = "1234"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nomor = trim($_POST['nomor_hp']);
    $sku   = trim($_POST['sku']); 
    $ref   = 'OKE' . date('His');
    
    $url = "https://h2h.okeconnect.com/trx"; 
    
    // Data dijadikan JSON murni
    $payload = json_encode([
        'user_id' => $user_id,
        'pin'     => $pin_oke,
        'produk'  => $sku,
        'nomor'   => $nomor,
        'm_reff'  => $ref
    ]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload); // Kirim JSON Mentah
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    // HEADER PALING LENGKAP: Biar dikira akses resmi
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($payload),
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
        'Origin: https://okeconnect.com',
        'Referer: https://okeconnect.com/integrasi/trx'
    ]);
    
    $response = curl_exec($ch);
    $hasil = json_decode($response, true);
    curl_close($ch);

    header('Content-Type: text/html');
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-slate-900 text-white flex items-center justify-center min-h-screen p-4">
        <div class="w-full max-w-sm bg-slate-800 rounded-3xl p-6 border border-slate-700 shadow-2xl">
            <h2 class="text-center text-xs font-black uppercase tracking-widest text-slate-500 mb-4 italic">Hasil Eksekusi</h2>
            
            <div class="bg-black rounded-2xl p-4 border border-slate-700 mb-6 overflow-auto">
                <pre class="text-[12px] font-mono text-green-400"><?php 
                if($hasil) {
                    echo json_encode($hasil, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
                } else {
                    // Kalo dapet teks "Not Allowed", kita bersihkan tag HTML-nya
                    echo strip_tags($response) ?: "KONEKSI TIME OUT";
                }
                ?></pre>
            </div>

            <a href="/" class="block w-full py-4 bg-blue-600 hover:bg-blue-500 text-center rounded-2xl font-black uppercase text-xs tracking-widest transition-all">ULANGI</a>
            
            <div class="mt-4 text-center">
                <p class="text-[9px] text-slate-600 italic">ID: <?php echo $user_id; ?> | SKU: <?php echo $sku; ?></p>
            </div>
        </div>
    </body>
    </html>
    <?php
}
?>
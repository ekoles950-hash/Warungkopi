<?php
// Data Akun Mas Eko
$memberID = "ekolestiyo"; 
$pin      = "9503"; 
$password = "Banjarnegara"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nomor   = trim($_POST['nomor_hp']);
    $produk  = trim($_POST['sku']);
    $refID   = 'BSCP' . date('His');
    
    // RUMUS SIGNATURE SESUAI DOKUMEN:
    // base64_encode(sha1("Otomax|" . memberID . "|" . product . "|" . dest . "|" . refID . "|" . pin . "|" . password))
    $raw_sign    = "Otomax|" . $memberID . "|" . $produk . "|" . $nomor . "|" . $refID . "|" . $pin . "|" . $password;
    $sha1_sign   = sha1($raw_sign);
    $signature   = base64_encode($sha1_sign);

    $url = "https://qiospay.id/api/h2h/trx"; 
    
    // Parameter Lengkap
    $params = [
        'product'  => $produk,
        'dest'     => $nomor,
        'refID'    => $refID,
        'memberID' => $memberID,
        'pin'      => $pin,
        'password' => $password,
        'sign'     => $signature
    ];

    // Kirim lewat GET sesuai instruksi dokumen
    $full_url = $url . "?" . http_build_query($params);

    $ch = curl_init($full_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $response = curl_exec($ch);
    curl_close($ch);

    header('Content-Type: text/html');
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-[#0f172a] flex items-center justify-center min-h-screen p-4">
        <div class="w-full max-w-md bg-white rounded-[2rem] p-8 shadow-2xl">
            <h2 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Respon Server Qiospay</h2>
            <div class="bg-slate-50 border-2 border-slate-100 rounded-2xl p-5 mb-6">
                <p class="font-mono text-sm text-slate-800 break-words italic">
                    <?php echo $response ?: "Server Qiospay tidak merespon"; ?>
                </p>
            </div>
            <a href="/" class="block w-full py-4 bg-blue-600 text-white text-center rounded-2xl font-bold hover:bg-blue-700 transition-all">
                KEMBALI KE WARUNG
            </a>
            <div class="mt-4 text-center">
                <p class="text-[9px] text-slate-400">ID: <?php echo $memberID; ?> | Sign: <?php echo substr($signature, 0, 10); ?>...</p>
            </div>
        </div>
    </body>
    </html>
    <?php
}
?>
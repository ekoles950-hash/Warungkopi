<?php
// Data Akun Mas Eko
$memberID = "ekolestiyo"; 
$pin      = "9503"; 
$password = "Banjarnegara"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nomor   = trim($_POST['nomor_hp']);
    $produk  = trim($_POST['sku']);
    $refID   = 'BSCP' . date('His');
    
    // RUMUS SIGNATURE (Wajib ada sesuai spek)
    $raw_sign    = "Otomax|" . $memberID . "|" . $produk . "|" . $nomor . "|" . $refID . "|" . $pin . "|" . $password;
    $signature   = base64_encode(sha1($raw_sign));

    $url = "https://qiospay.id/api/h2h/trx"; 
    
    $params = [
        'product'  => $produk,
        'dest'     => $nomor,
        'refID'    => $refID,
        'memberID' => $memberID,
        'pin'      => $pin,
        'password' => $password,
        'sign'     => $signature
    ];

    $full_url = $url . "?" . http_build_query($params);

    $ch = curl_init($full_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    // INI KUNCINYA: Menyamar jadi HP Android biar nggak diblokir Vercel-nya
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Linux; Android 10; Redmi Note 8) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Mobile Safari/537.36');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    header('Content-Type: text/html');
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-[#0f172a] flex items-center justify-center min-h-screen p-4 font-sans">
        <div class="w-full max-w-md bg-white rounded-3xl p-8 shadow-2xl border-t-8 border-blue-600">
            <h2 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Laporan Sistem H2H</h2>
            
            <div class="bg-slate-50 border-2 border-slate-100 rounded-2xl p-5 mb-6">
                <p class="font-mono text-sm text-slate-800 break-words leading-relaxed">
                    <?php 
                    if($httpCode == 403 || $httpCode == 406) {
                        echo "⚠️ Vercel Masih Diblokir (Error $httpCode). Server Qiospay menolak koneksi dari Vercel.";
                    } else {
                        echo $response ?: "Tidak ada respon (Timeout)";
                    }
                    ?>
                </p>
            </div>

            <a href="/" class="block w-full py-4 bg-blue-600 text-white text-center rounded-2xl font-black uppercase text-xs tracking-widest hover:bg-blue-700 transition-all">
                Coba Lagi
            </a>
        </div>
    </body>
    </html>
    <?php
}
?>
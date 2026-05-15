<?php
// Data dari screenshot panel integrasi Mas Eko
$memberID = "082243047166"; 
$pin      = "9503"; 
$password = "Banjarnegara"; // Sesuai screenshot password di panel Mas

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nomor   = trim($_POST['nomor_hp']);
    $produk  = trim($_POST['sku']);
    $refID   = 'BSCP' . date('His');
    
    // URL API Qiospay sesuai dokumen
    $url = "https://qiospay.id/api/h2h/trx"; 
    
    // Variabel WAJIB sesuai screenshot dokumen (huruf kecil-besar pengaruh)
    $params = [
        'product'  => $produk,
        'dest'     => $nomor,
        'refID'    => $refID,
        'memberID' => $memberID,
        'pin'      => $pin,
        'password' => $password
    ];

    // Kirim pakai GET sesuai contoh "GET - Transaksi" di dokumen
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
    <html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-[#0f172a] flex items-center justify-center min-h-screen p-4">
        <div class="w-full max-w-md bg-white rounded-[2rem] p-8 shadow-2xl">
            <h2 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Respon Server Qiospay</h2>
            <div class="bg-slate-50 border-2 border-slate-100 rounded-2xl p-5 mb-6">
                <p class="font-mono text-sm text-slate-800 break-words">
                    <?php echo $response ?: "Tidak ada respon dari server"; ?>
                </p>
            </div>
            <a href="/" class="block w-full py-4 bg-blue-600 text-white text-center rounded-xl font-bold hover:bg-blue-700 transition-all">
                KEMBALI
            </a>
        </div>
    </body>
    </html>
    <?php
}
?>
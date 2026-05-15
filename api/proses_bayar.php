<?php
// Data Akun Terbaru Mas Eko
$my_id  = "ekolestiyo"; 
$my_pin = "9503"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nomor = trim($_POST['nomor_hp']);
    $sku   = trim($_POST['sku']);
    $reff  = 'BSCP' . date('His');
    
    $url = "https://qiospay.id/api/h2h/trx"; 
    
    // Variabel sesuai dokumen resmi Qiospay
    $params = [
        'ID'      => $my_id,
        'PIN'     => $my_pin,
        'PRODUK'  => $sku,
        'NOMOR'   => $nomor,
        'ID_REFF' => $reff
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params)); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    
    $response = curl_exec($ch);
    $hasil = json_decode($response, true);
    curl_close($ch);

    header('Content-Type: text/html');
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body { background: #0f172a; font-family: 'Courier New', monospace; padding: 20px; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
            .box { background: #ffffff; padding: 30px; border-radius: 24px; shadow: 0 25px 50px -12px rgba(0,0,0,0.5); width: 100%; max-width: 400px; border-top: 6px solid #3b82f6; }
            pre { white-space: pre-wrap; word-wrap: break-word; color: #1e293b; font-size: 14px; background: #f8fafc; padding: 20px; border-radius: 15px; border: 1px solid #e2e8f0; margin: 15px 0; }
            .label { font-size: 11px; color: #64748b; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; }
            .btn { display: block; text-align: center; padding: 16px; background: #3b82f6; color: white; text-decoration: none; border-radius: 14px; font-family: sans-serif; font-weight: 900; font-size: 14px; transition: 0.3s; }
            .btn:hover { background: #2563eb; }
        </style>
    </head>
    <body>
        <div class="box">
            <span class="label">Status Transaksi:</span>
            <pre><?php 
            if($hasil) {
                echo json_encode($hasil, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            } else {
                echo htmlspecialchars($response) ?: "Koneksi Gagal ke Qiospay";
            }
            ?></pre>
            <a href="/" class="btn">KEMBALI KE BERANDA</a>
        </div>
    </body>
    </html>
    <?php
}
?>
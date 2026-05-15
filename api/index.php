<?php
$user_id  = "OK2302353"; 
$pin_oke  = "1234"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nomor = trim($_POST['nomor_hp']);
    $sku   = trim($_POST['sku']); 
    $ref   = 'OKE' . date('His');
    
    $url = "https://h2h.okeconnect.com/trx"; 
    
    $payload = [
        'user_id' => $user_id,
        'pin'     => $pin_oke,
        'produk'  => $sku,
        'nomor'   => $nomor,
        'm_reff'  => $ref
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    
    // PERUBAHAN DISINI: Kirim mentah JSON + Header Lengkap
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload)); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Accept: application/json',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
    ]);
    
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $response = curl_exec($ch);
    $hasil = json_decode($response, true);
    curl_close($ch);

    header('Content-Type: text/html');
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body { background: #f4f7f6; font-family: monospace; padding: 20px; display: flex; justify-content: center; }
            .card { background: white; padding: 25px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); width: 100%; max-width: 450px; border: 1px solid #e0e0e0; }
            pre { white-space: pre-wrap; word-wrap: break-word; color: #2d3436; font-size: 13px; line-height: 1.6; margin: 0; }
            .header { border-bottom: 2px solid #00b894; padding-bottom: 10px; margin-bottom: 15px; font-weight: bold; color: #00b894; text-transform: uppercase; }
            .btn { display: block; text-align: center; margin-top: 20px; padding: 12px; background: #00b894; color: white; text-decoration: none; border-radius: 8px; font-weight: bold; font-family: sans-serif; }
        </style>
    </head>
    <body>
        <div class="card">
            <div class="header">STATUS TRANSAKSI</div>
            <pre><?php 
            if($hasil) {
                echo json_encode($hasil, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            } else {
                // Jika masih dapet pesan "Not Allowed", tampilkan respon aslinya
                echo $response ? htmlspecialchars($response) : "Server OkeConnect tidak merespon.";
            }
            ?></pre>
            <a href="/" class="btn">KEMBALI</a>
        </div>
    </body>
    </html>
    <?php
}
?>
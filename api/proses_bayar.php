<?php
// Update Data OkeConnect Mas Eko
$user_id  = "OK2302353"; 
$pin_oke  = "1234"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Bersihkan spasi otomatis
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
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload)); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
    
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
            body { background: #f4f7f6; font-family: 'Courier New', monospace; padding: 20px; display: flex; justify-content: center; }
            .container { background: white; padding: 25px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); width: 100%; max-width: 450px; border: 1px solid #e0e0e0; }
            pre { white-space: pre-wrap; word-wrap: break-word; color: #2d3436; font-size: 13px; line-height: 1.6; margin: 0; }
            .header { border-bottom: 2px solid #f0f0f0; padding-bottom: 10px; margin-bottom: 15px; font-weight: bold; color: #00b894; font-size: 11px; text-transform: uppercase; }
            .btn { display: block; text-align: center; margin-top: 20px; padding: 12px; background: #00b894; color: white; text-decoration: none; border-radius: 8px; font-weight: bold; font-family: sans-serif; font-size: 14px; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">Respon OkeConnect - Basecamp</div>
            <pre><?php 
            if($hasil) {
                echo json_encode($hasil, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            } else {
                echo "{\n  \"status\": \"FAILED\",\n  \"message\": \"$response\"\n}";
            }
            ?></pre>
            <a href="/" class="btn">KEMBALI</a>
        </div>
    </body>
    </html>
    <?php
}
?>
<?php
$user_id  = "ekolestiyo"; 
$pin_qios = "123456"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nomor = trim($_POST['nomor_hp']);
    $sku   = trim($_POST['sku']);
    $ref   = 'GRAB' . date('His');
    
    $url = "https://qiospay.id/api/h2h/trx"; 
    
    // Kirim data mentah (raw data)
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
    
    $response = curl_exec($ch);
    $hasil = json_decode($response, true);
    curl_close($ch);

    // TAMPILAN PUTIH BERSIH ALA BUKAOLSHOP
    header('Content-Type: text/html');
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body { background: #f4f4f4; font-family: monospace; padding: 20px; }
            .box { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); max-width: 500px; margin: auto; }
            pre { white-space: pre-wrap; word-wrap: break-word; color: #333; font-size: 13px; }
        </style>
    </head>
    <body>
        <div class="box">
            <pre><?php 
            if($hasil) {
                echo json_encode($hasil, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            } else {
                echo "{\n  \"status\": \"ERROR\",\n  \"message\": \"$response\"\n}";
            }
            ?></pre>
        </div>
    </body>
    </html>
    <?php
}
?>
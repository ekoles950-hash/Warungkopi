<?php
$user_id  = "OK2302353"; 
$pin_qios = "1234"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fungsi trim() buat hapus spasi "setan" di depan/belakang
    $nomor = trim($_POST['nomor_hp']);
    $sku   = trim($_POST['sku']);
    $ref   = 'GRAB' . date('His');
    
    $url = "https://h2h.okeconnect.com/trx"; 
    
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

    header('Content-Type: text/html');
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body { background: #f5f5f5; font-family: monospace; padding: 20px; display: flex; justify-content: center; }
            .box { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); width: 100%; max-width: 400px; border: 1px solid #eee; }
            pre { white-space: pre-wrap; word-wrap: break-word; color: #333; font-size: 14px; margin: 0; line-height: 1.6; }
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
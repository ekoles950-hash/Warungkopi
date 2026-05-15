<?php
$user_id  = "OK2302353"; 
$pin_oke  = "1234"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nomor = trim($_POST['nomor_hp']);
    $sku   = trim($_POST['sku']); 
    $ref   = 'OKE' . date('His');
    
    $url = "https://h2h.okeconnect.com/trx"; 
    
    // Kirim pakai format STRING (Metode paling ampuh buat server rewel)
    $fields = "user_id=$user_id&pin=$pin_oke&produk=$sku&nomor=$nomor&m_reff=$ref";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields); // Kirim string mentah
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    // Paksa pake Header Chrome biar gak diblokir firewall mereka
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
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
        <style>
            body { background: white; font-family: monospace; padding: 20px; }
            .box { border: 2px solid black; padding: 15px; max-width: 400px; margin: auto; }
            pre { white-space: pre-wrap; font-size: 14px; color: red; font-weight: bold; }
        </style>
    </head>
    <body>
        <div class="box">
            <h2 style="font-size: 12px; border-bottom: 1px solid #000; padding-bottom: 5px;">RESPON SERVER:</h2>
            <pre><?php 
            if($hasil) {
                echo json_encode($hasil, JSON_PRETTY_PRINT);
            } else {
                echo $response ? htmlspecialchars($response) : "SERVER OKE CONNECT MATI/BLOKIR IP";
            }
            ?></pre>
            <hr>
            <p style="font-size: 10px;">Data: ID:<?php echo $user_id; ?> | PIN:<?php echo $pin_oke; ?> | SKU:<?php echo $sku; ?></p>
            <a href="/" style="display:block; text-align:center; background: black; color: white; padding: 10px; text-decoration: none; font-weight: bold;">KEMBALI</a>
        </div>
    </body>
    </html>
    <?php
}
?>
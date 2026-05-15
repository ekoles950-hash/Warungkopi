<?php
// Data Akun Mas Eko
$my_id  = "ekolestiyo"; 
$my_pin = "9503"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nomor = trim($_POST['nomor_hp']);
    $sku   = trim($_POST['sku']);
    $reff  = 'BSCP' . date('His');
    
    $url = "https://qiospay.id/api/h2h/trx"; 
    
    // Format WAJIB sesuai dokumentasi CS
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
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params)); // Kirim format Form
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
            body { background: #f1f5f9; font-family: monospace; padding: 20px; display: flex; justify-content: center; }
            .box { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); width: 100%; max-width: 400px; border-top: 4px solid #2563eb; }
            pre { white-space: pre-wrap; word-wrap: break-word; color: #1e293b; font-size: 13px; background: #f8fafc; padding: 15px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 10px; }
            .status-label { font-size: 10px; color: #64748b; font-weight: bold; text-transform: uppercase; }
        </style>
    </head>
    <body>
        <div class="box">
            <span class="status-label">Hasil Respon Qiospay:</span>
            <pre><?php 
            if($hasil) {
                echo json_encode($hasil, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            } else {
                echo htmlspecialchars($response) ?: "Koneksi Gagal / Server RTO";
            }
            ?></pre>
            <a href="/" style="display:block; text-align:center; margin-top:15px; padding:12px; background:#2563eb; color:white; text-decoration:none; border-radius:8px; font-family:sans-serif; font-weight:bold; font-size:13px;">KEMBALI</a>
        </div>
    </body>
    </html>
    <?php
}
?>
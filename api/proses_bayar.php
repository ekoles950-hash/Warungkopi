<?php
// Sesuaikan dengan data Mas Eko
$my_id   = "ekolestiyo"; 
$my_pin  = "123456"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nomor_tujuan = trim($_POST['nomor_hp']);
    $kode_produk  = trim($_POST['sku']);
    $reff_id      = 'GRAB' . date('His');
    
    // URL sesuai dokumen CS
    $url = "https://qiospay.id/api/h2h/trx"; 
    
    // Variabel WAJIB HURUF BESAR sesuai instruksi CS
    $data_kirim = [
        'ID'      => $my_id,
        'PIN'     => $my_pin,
        'PRODUK'  => $kode_produk,
        'NOMOR'   => $nomor_tujuan,
        'ID_REFF' => $reff_id
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    // Kirim sebagai FORM DATA biasa (bukan JSON)
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_kirim)); 
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
            body { background: #f0f2f5; font-family: monospace; padding: 20px; display: flex; justify-content: center; }
            .box { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); width: 100%; max-width: 400px; border-top: 5px solid #2563eb; }
            pre { white-space: pre-wrap; word-wrap: break-word; color: #1e293b; font-size: 14px; background: #f8fafc; padding: 15px; border-radius: 8px; }
            .label { font-size: 10px; color: #64748b; font-weight: bold; margin-bottom: 5px; display: block; }
        </style>
    </head>
    <body>
        <div class="box">
            <span class="label">RESPON RESMI QIOSPAY</span>
            <pre><?php 
            if($hasil) {
                echo json_encode($hasil, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            } else {
                echo "Gagal konek ke server. Respon: " . htmlspecialchars($response);
            }
            ?></pre>
            <a href="/" style="display:block; text-align:center; margin-top:15px; padding:12px; background:#2563eb; color:white; text-decoration:none; border-radius:8px; font-family:sans-serif; font-weight:bold;">KEMBALI</a>
        </div>
    </body>
    </html>
    <?php
}
?>
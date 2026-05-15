<?php
// Data Akun Mas Eko
$user_id  = "ekolestiyo"; 
$pin_qios = "1234"; // PASTIKAN PIN INI SAMA DENGAN DI PANEL QIOSPAY

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nomor = $_POST['nomor_hp'];
    $sku   = $_POST['sku'];
    $ref   = 'GRAB' . date('His'); // ID unik transaksi

    // URL API Qiospay
    $url = "https://qiospay.id/api/h2h/trx"; 
    
    $payload = [
        'user_id' => $user_id,
        'pin'     => $pin_qios,
        'nomor'   => $nomor,
        'produk'  => $sku,
        'm_reff'  => $ref
    ];

    // Proses kirim data ke Qiospay
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    $hasil = json_decode($response, true);

    // TAMPILAN STATUS
    echo "<!DOCTYPE html><html><head><meta name='viewport' content='width=device-width, initial-scale=1.0'><script src='https://cdn.tailwindcss.com'></script></head>
    <body class='bg-slate-900 text-white flex items-center justify-center min-h-screen p-6 font-sans'>";
    
    echo "<div class='bg-slate-800 p-8 rounded-3xl border border-slate-700 text-center w-full max-w-sm shadow-2xl'>";
    
    if ($error) {
        // Jika Vercel gagal kirim data ke Qiospay
        echo "<h2 class='text-red-500 font-bold text-lg uppercase mb-2'>Gagal Koneksi</h2>";
        echo "<p class='text-[10px] text-slate-400 italic'>Pesan: $error</p>";
    } else {
        if (isset($hasil['status']) && $hasil['status'] == 'success') {
            // Berhasil
            echo "<div class='bg-green-500/20 p-4 rounded-2xl mb-4 border border-green-500'>";
            echo "<h2 class='text-green-500 font-black text-xl uppercase italic'>Sukses!</h2>";
            echo "</div>";
            echo "<p class='text-xs text-slate-300'>$sku sedang dikirim ke <br><span class='text-white font-bold'>$nomor</span></p>";
        } else {
            // Jika Qiospay menolak (misal: Saldo Mas abis atau PIN salah)
            $msg = $hasil['message'] ?? 'Respon Server Kosong';
            echo "<h2 class='text-yellow-500 font-bold text-lg uppercase mb-2 italic'>Gagal</h2>";
            echo "<div class='bg-slate-900 p-3 rounded-xl border border-slate-700'>";
            echo "<p class='text-[10px] text-slate-400'>$msg</p>";
            echo "</div>";
        }
    }

    echo "<p class='text-[9px] text-slate-600 mt-6 uppercase tracking-widest'>ID Ref: $ref</p>";
    echo "<button onclick='window.location.href=\"/\"' class='bg-blue-600 hover:bg-blue-500 w-full py-4 rounded-2xl font-black mt-4 transition shadow-lg shadow-blue-900/20 uppercase tracking-widest text-xs'>Kembali</button>";
    echo "</div></body></html>";
} else {
    // Balik ke depan kalau diakses langsung
    header('Location: /');
}
?>
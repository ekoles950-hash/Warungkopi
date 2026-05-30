export default async function handler(req, res) {
    if (req.method !== 'POST') {
        return res.status(405).json({ status: false, pesan: 'Hanya menerima POST' });
    }

    // 🚨 Link Cloudflare Termux lo yang baru nyala 🚨
    const termuxUrl = "https://anymore-glenn-devon-oasis.trycloudflare.com/topup.php";

    const { noHp, idLayanan } = req.body;

    try {
        // Kirim data pesanan web ke HP Redmi Note 8 lo via Cloudflare
        const response = await fetch(termuxUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                nomor: noHp,
                kode_produk: idLayanan
            })
        });

        // Tangkap surat balasan dari Termux (OkeConnect)
        const textResult = await response.text();
        
        // Cek apakah transaksinya sukses (OkeConnect biasanya membalas dengan kata PENDING, SUKSES, atau kode 00)
        if (textResult.toUpperCase().includes("SUKSES") || textResult.toUpperCase().includes("PENDING") || textResult.includes("00")) {
            return res.status(200).json({ status: true, pesan: "Transaksi Berhasil", data: textResult });
        } else {
            // Kalau gagal (misal nomor salah atau saldo kurang)
            return res.status(200).json({ status: false, pesan: textResult || "Transaksi Gagal / Saldo Kurang" });
        }

    } catch (error) {
        // Kalau error ini muncul di web, berarti Termux mati atau link trycloudflare-nya minta diganti lagi
        return res.status(500).json({ status: false, pesan: "Server Warung Mati / Link Berubah" });
    }
}
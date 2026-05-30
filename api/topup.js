export default async function handler(req, res) {
    if (req.method !== 'POST') {
        return res.status(405).json({ status: false, pesan: 'Hanya menerima POST' });
    }

    // 🚨 LINK BARU SESUAI HASIL TERMUX LO 🚨
    const termuxUrl = "https://bedford-change-researchers-president.trycloudflare.com/topup.php";

    const { noHp, idLayanan } = req.body;

    try {
        // Kirim data pesanan ke Termux
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

        const textResult = await response.text();
        
        // Cek hasil dari OkeConnect
        if (textResult.toUpperCase().includes("SUKSES") || textResult.toUpperCase().includes("PENDING") || textResult.includes("00")) {
            return res.status(200).json({ status: true, pesan: "Transaksi Berhasil", data: textResult });
        } else {
            return res.status(200).json({ status: false, pesan: textResult || "Transaksi Gagal / Saldo Kurang" });
        }

    } catch (error) {
        return res.status(500).json({ status: false, pesan: "Server Warung Mati / Link Berubah" });
    }
}
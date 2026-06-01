export default async function handler(req, res) {
    if (req.method !== 'POST') {
        return res.status(405).json({ error: 'Metode tidak diizinkan' });
    }

    const { nomor, kode_produk } = req.body;
    const termuxUrl = "https://grabwarung.mkz.my.id/topup.php";

    try {
        const response = await fetch(termuxUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ nomor, kode_produk })
        });

        const data = await response.text();
        // Kirim balik respon asli dari hosting ke Vercel
        res.status(200).send(data);
    } catch (error) {
        // Kirim detail error agar kita tahu kenapa gagal
        res.status(500).json({ error: 'Gagal hubungi server: ' + error.message });
    }
}
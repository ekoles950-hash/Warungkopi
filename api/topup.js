export default async function handler(req, res) {
    // Pastikan hanya metode POST yang diizinkan
    if (req.method !== 'POST') {
        return res.status(405).json({ error: 'Metode tidak diizinkan' });
    }

    const { nomor, kode_produk } = req.body;

    // Alamat file PHP baru di hosting
    const termuxUrl = "https://grabwarung.mkz.my.id/topup.php";

    try {
        const response = await fetch(termuxUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                nomor: nomor,
                kode_produk: kode_produk
            })
        });

        const data = await response.text();
        res.status(200).send(data);
    } catch (error) {
        res.status(500).json({ error: 'Gagal menghubungi server hosting' });
    }
}
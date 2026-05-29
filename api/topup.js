// Lokasi: api/topup.js
// Ini berjalan di belakang layar (Server Vercel), jadi bebas dari pemblokiran CORS

export default async function handler(req, res) {
  // Hanya terima POST dari web lo
  if (req.method !== 'POST') {
    return res.status(405).json({ status: false, pesan: 'Method Not Allowed' });
  }

  const { noHp } = req.body;

  // Kredensial Lo
  const link = "https://village.elyng.com/api/v2/ppob"; // Sesuai dokumentasi lo
  const apiKey = "ABcdEfghiJklmNOpqrstuvwXYZ"; // Wajib diisi!
  const privateKey = "6BdSctikB-xJyfn-yIYFDFibMY2-FHiLeXA-jU6p4";
  
  // CATATAN: Di teks dokumen yang lo kirim, 'layanan-prabayar' itu untuk MELIHAT DAFTAR. 
  // Untuk TRANSAKSI, biasanya action-nya 'order' atau 'transaksi'. Cek lagi di menu "API PPOB" khusus transaksi.
  const action = "order"; // Ganti jika di dokumentasi transaksi action-nya berbeda
  const idLayanan = "DN5";
  const pin = "959595";

  // Rangkai URL
  const paymentUrl = `${link}?api_key=${apiKey}&private_key=${privateKey}&action=${action}&layanan=${idLayanan}&target=${noHp}&pin=${pin}`;

  try {
    const response = await fetch(paymentUrl, {
      method: 'POST',
      headers: {
        'Referer': req.headers['host'] || 'warungkopi-lac.vercel.app',
      }
    });

    const data = await response.json();
    
    // Kembalikan hasil dari Village Payment ke web lo
    return res.status(200).json(data);

  } catch (error) {
    return res.status(500).json({ status: false, pesan: "Error di Server Vercel." });
  }
}
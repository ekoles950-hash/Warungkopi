// Lokasi: api/topup.js

export default async function handler(req, res) {
  if (req.method !== 'POST') {
    return res.status(405).json({ status: false, pesan: 'Method Not Allowed' });
  }

  const { noHp } = req.body;

  // =================================================================
  // KREDENSIAL LENGKAP SESUAI DOKUMENTASI BARU
  // =================================================================
  const link = "https://village.elyng.com/api/v2/ppob"; 
  
  // ⚠️ JANGAN LUPA: Ganti tulisan ini dengan API KEY asli lo!
  const apiKey = "EbQmQqVrrBhb35uCJhX1"; 
  const privateKey = "6BdSctikB-xJyfn-yIYFDFibMY2-FHiLeXA-jU6p4";
  
  // Menggunakan parameter persis seperti dokumentasi
  const action = "prabayar"; 
  const id = "DN5"; 
  const target = noHp;
  // =================================================================

  // Rangkai URL tanpa PIN (Kecuali memang disuruh CS mereka)
  const paymentUrl = `${link}?api_key=${apiKey}&private_key=${privateKey}&action=${action}&id=${id}&target=${target}`;

  try {
    const clientIp = req.headers['x-forwarded-for'] || '127.0.0.1';
    const hostName = req.headers['host'] || 'warungkopi-lac.vercel.app';

    const response = await fetch(paymentUrl, {
      method: 'POST',
      headers: {
        'Referer': hostName,
        'X-Forwarded-For': clientIp
      }
    });

    const data = await response.json();
    
    // Langsung lemparkan jawaban dari Village Payment ke frontend
    return res.status(200).json(data);

  } catch (error) {
    return res.status(500).json({ status: false, pesan: "Error di Server Vercel." });
  }
}
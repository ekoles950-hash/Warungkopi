export default async function handler(req, res) {
  // Hanya izinkan tembakan POST dari form aplikasi
  if (req.method !== 'POST') {
    return res.status(405).json({ error: 'Metode tidak diizinkan. Gunakan POST.' });
  }

  // Menangkap data yang dikirim dari web Basecamp Coffee
  const { kode_produk, nomor_tujuan, pin } = req.body;

  // Validasi jika ada form yang kosong
  if (!kode_produk || !nomor_tujuan || !pin) {
    return res.status(400).json({ error: 'Data pesanan tidak lengkap!' });
  }

  // Merakit format rahasia yang akan dibaca oleh Termux (Contoh: DN5.0812345.123)
  const pesanTermux = `${kode_produk}.${nomor_tujuan}.${pin}`;

  // Mengambil token dan ID Telegram dari Environment Variables Vercel
  const BOT_TOKEN = process.env.TELEGRAM_BOT_TOKEN;
  const CHAT_ID = process.env.TELEGRAM_CHAT_ID;

  if (!BOT_TOKEN || !CHAT_ID) {
    return res.status(500).json({ error: 'Token Bot atau Chat ID belum disetting di Vercel!' });
  }

  const urlTelegram = `https://api.telegram.org/bot${BOT_TOKEN}/sendMessage`;

  try {
    console.log(`Mengirim ke Termux: ${pesanTermux}`);
    
    // Menembak pesan ke Telegram
    const tembakTele = await fetch(urlTelegram, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        chat_id: CHAT_ID,
        text: pesanTermux,
      }),
    });

    const responTele = await tembakTele.json();

    if (responTele.ok) {
      // Jika Telegram sukses menerima
      return res.status(200).json({ 
        sukses: true, 
        pesan: 'Pesanan berhasil dikirim ke Mesin Termux!' 
      });
    } else {
      // Jika Telegram menolak
      return res.status(500).json({ 
        sukses: false, 
        pesan: 'Gagal menembak ke Telegram', 
        detail: responTele.description 
      });
    }

  } catch (error) {
    // Jika server Vercel error
    return res.status(500).json({ 
      sukses: false, 
      pesan: 'Server Vercel Error', 
      detail: error.message 
    });
  }
}
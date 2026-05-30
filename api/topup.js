// Lokasi: api/topup.js

export default async function handler(req, res) {
  if (req.method !== 'POST') {
    return res.status(405).json({ status: false, pesan: 'Method Not Allowed' });
  }

  // =================================================================
  // 1. DATA LOGIN & TARGET URL BARU
  // =================================================================
  const loginUrl = "https://village.elyng.com/auth/login"; // URL fix dari lo
  const targetUrl = "https://village.elyng.com/order/saldo-emoney";

  const loginData = new URLSearchParams();
  loginData.append('username', 'termux'); 
  loginData.append('password', 'termux 123'); 

  try {
    // =================================================================
    // 2. FASE EKSEKUSI LOGIN (MENCARI COOKIE)
    // =================================================================
    const loginResponse = await fetch(loginUrl, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
        'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
      },
      body: loginData.toString(),
      redirect: 'manual' 
    });

    // Ambil tiket masuknya
    const sessionCookie = loginResponse.headers.get('set-cookie');

    if (!sessionCookie) {
      return res.status(400).json({ 
        status: false, 
        pesan: "Gagal Login: Cookie tidak ditemukan. Web kemungkinan menolak login otomatis atau butuh Token CSRF tambahan." 
      });
    }

    // =================================================================
    // 3. FASE MENEMBUS HALAMAN ORDER (MEMBAWA TIKET COOKIE)
    // =================================================================
    // Cukup ambil cookie utama, buang parameter tambahan (seperti Path=/ dll) biar server gak bingung
    const cleanCookie = sessionCookie.split(';')[0];

    const targetResponse = await fetch(targetUrl, {
      method: 'GET',
      headers: {
        'Cookie': cleanCookie, 
        'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
      }
    });

    const htmlMentah = await targetResponse.text();

    // Mengirimkan hasil sedotan HTML ke layar web lo
    return res.status(200).send(htmlMentah);

  } catch (error) {
    console.error("Error Sistem:", error);
    return res.status(500).json({ status: false, pesan: "Error sistem bypass di Vercel." });
  }
}
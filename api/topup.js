// Lokasi file: api/topup.js

export default async function handler(req, res) {
  if (req.method !== 'POST') {
    return res.status(405).json({ status: false, pesan: 'Method Not Allowed' });
  }

  const { noHp } = req.body;
  const loginUrl = "https://village.elyng.com/auth/login";
  const targetUrl = "https://village.elyng.com/order/saldo-emoney";
  
  // Nyamar jadi browser beneran biar nggak diblokir
  const userAgent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36";

  try {
    // =================================================================
    // TAHAP 1: Nyuri CSRF Token dan Karcis Awal
    // =================================================================
    const step1 = await fetch(loginUrl, {
      method: 'GET',
      headers: { 'User-Agent': userAgent }
    });
    
    const htmlStep1 = await step1.text();
    let initialCookie = step1.headers.get('set-cookie');
    
    // Mengekstrak CSRF Token dari HTML pakai Regex
    const csrfMatch = htmlStep1.match(/<input type="hidden" name="csrf_token" value="([^"]+)">/);
    if (!csrfMatch) {
      return res.status(400).json({ status: false, pesan: "Gagal nyuri CSRF Token." });
    }
    const csrfToken = csrfMatch[1]; // Ini token rahasianya!

    // Rapikan Cookie
    let parsedCookie = initialCookie ? initialCookie.split(';')[0] : "";

    // =================================================================
    // TAHAP 2: Eksekusi Login dengan Token Curian
    // =================================================================
    const loginData = new URLSearchParams();
    loginData.append('csrf_token', csrfToken); // Masukkan token curian
    loginData.append('username', 'termux');
    loginData.append('password', 'termux 123');
    loginData.append('masuk', ''); // Web lo butuh parameter tombol masuk diklik

    const step2 = await fetch(loginUrl, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
        'User-Agent': userAgent,
        'Cookie': parsedCookie, // Bawa karcis awalnya
        'Referer': loginUrl
      },
      body: loginData.toString(),
      redirect: 'manual' 
    });

    // Ambil karcis VIP (Cookie yang sudah tervalidasi setelah login)
    let finalCookie = step2.headers.get('set-cookie') || parsedCookie;
    let cleanFinalCookie = finalCookie.split(';')[0];

    // =================================================================
    // TAHAP 3: Buka Halaman Target (Order Emoney)
    // =================================================================
    const targetResponse = await fetch(targetUrl, {
      method: 'GET',
      headers: {
        'Cookie': cleanFinalCookie, // Bawa karcis VIP ke dalam halaman
        'User-Agent': userAgent,
        'Referer': "https://village.elyng.com/"
      }
    });

    const htmlMentah = await targetResponse.text();
    
    // Lemparkan hasil HTML ke web lo
    return res.status(200).send(htmlMentah);

  } catch (error) {
    console.error("Error Sistem:", error);
    return res.status(500).json({ status: false, pesan: "Error Bypass Vercel: " + error.message });
  }
}
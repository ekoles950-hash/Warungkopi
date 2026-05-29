export default async function handler(req, res) {
  if (req.method !== 'POST') {
    return res.status(405).json({ status: false, pesan: 'Method Not Allowed' });
  }

  const { noHp } = req.body;

  // Kredensial fix
  const link = "https://village.elyng.com/api/v2/ppob"; 
  const apiKey = "EbQmQqVrrBhb35uCJhX1"; 
  const privateKey = "6BdSctikB-xJyfn-yIYFDFibMY2-FHiLeXA-jU6p4";
  
  const action = "prabayar"; 
  const id = "DN5"; 
  const target = noHp;

  const paymentUrl = `${link}?api_key=${apiKey}&private_key=${privateKey}&action=${action}&id=${id}&target=${target}`;

  try {
    // TWEAK PENTING: Bersihkan IP Vercel dari koma ganda
    const rawIp = req.headers['x-forwarded-for'] || '127.0.0.1';
    const cleanIp = rawIp.split(',')[0].trim(); 
    const hostName = req.headers['host'] || 'warungkopi-lac.vercel.app';

    const response = await fetch(paymentUrl, {
      method: 'POST',
      headers: {
        'Referer': hostName,
        'X-Forwarded-For': cleanIp,
        'User-Agent': 'Mozilla/5.0 (Vercel App)', // Biar server nggak ngira ini bot aneh
        'Accept': 'application/json'
      }
    });

    const data = await response.json();
    return res.status(200).json(data);

  } catch (error) {
    return res.status(500).json({ status: false, pesan: "Error di Server Vercel." });
  }
}
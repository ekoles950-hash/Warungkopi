export default async function handler(req, res) {
  if (req.method !== 'POST') {
    return res.status(405).json({ status: false, pesan: 'Method Not Allowed' });
  }

  const { noHp } = req.body;
  const link = "https://village.elyng.com/api/v2/ppob"; 

  // KITA UBAH FORMATNYA: Masukkan ke Body sebagai URLSearchParams (Form Data)
  const formData = new URLSearchParams();
  formData.append('api_key', 'EbQmQqVrrBhb35uCJhX1');
  formData.append('private_key', '6BdSctikB-xJyfn-yIYFDFibMY2-FHiLeXA-jU6p4');
  formData.append('action', 'prabayar');
  formData.append('id', 'DN5');
  formData.append('target', noHp);

  try {
    // Perhatikan: Kita nembak ke 'link' langsung, TUKAN ke paymentUrl yang ada tanda tanya (?) nya.
    const response = await fetch(link, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded', // Format wajib untuk POST form
        // Gue matiin header X-Forwarded-For dan Referer biar gak dicurigai sistem keamanan mereka
      },
      body: formData.toString() // Datanya diselipkan di sini
    });

    const data = await response.json();
    return res.status(200).json(data);

  } catch (error) {
    return res.status(500).json({ status: false, pesan: "Error di Server Vercel." });
  }
}
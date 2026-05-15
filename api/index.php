<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRABNDESO - Top Up</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-white flex items-center justify-center min-h-screen p-4">
    <div class="max-w-md w-full bg-slate-800 p-8 rounded-3xl shadow-2xl border border-slate-700">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-black italic tracking-tighter uppercase">Grab<span class="text-green-500">ndeso</span></h1>
            <p class="text-[10px] text-slate-400 mt-1 uppercase tracking-widest text-blue-400 font-bold">Vercel Serverless</p>
        </div>
        
        <form action="/proses" method="POST">
            <div class="mb-6">
                <label class="block text-[10px] font-bold text-slate-500 mb-2 tracking-widest uppercase">Nomor HP Tujuan</label>
                <input type="number" name="nomor_hp" placeholder="08xxxxxxxx" class="w-full bg-slate-900 border border-slate-700 rounded-2xl p-4 text-white focus:outline-none focus:border-green-500 font-mono" required>
            </div>

            <div class="mb-8">
                <label class="block text-[10px] font-bold text-slate-500 mb-2 tracking-widest uppercase">Pilih Saldo</label>
                <div class="grid grid-cols-1 gap-3">
                    <label class="flex items-center p-4 bg-slate-900 border border-slate-700 rounded-2xl cursor-pointer hover:border-blue-500">
                        <input type="radio" name="sku" value="GPY1" class="w-4 h-4 text-green-500" required>
                        <span class="ml-4 font-bold text-sm uppercase">Gopay 2.050</span>
                        <span class="ml-auto font-bold text-green-500 text-sm">Rp 2.000</span>
                    </label>
                    <label class="flex items-center p-4 bg-slate-900 border border-slate-700 rounded-2xl cursor-pointer hover:border-blue-500">
                        <input type="radio" name="sku" value="DANA1" class="w-4 h-4 text-blue-500">
                        <span class="ml-4 font-bold text-sm uppercase">Dana 1.000</span>
                        <span class="ml-auto font-bold text-blue-500 text-sm">Rp 2.000</span>
                    </label>
                </div>
            </div>

            <button type="submit" class="w-full bg-green-600 hover:bg-green-500 text-white font-black py-4 rounded-2xl transition shadow-lg uppercase tracking-widest text-sm">Bayar Sekarang</button>
        </form>
    </div>
</body>
</html>
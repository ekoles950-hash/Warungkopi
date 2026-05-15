<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basecamp Coffee - Topup</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap');
        body { font-family: 'Inter', sans-serif; }
        input:checked + label {
            border-color: #2563eb;
            background-color: #eff6ff;
            color: #1e40af;
        }
    </style>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md bg-white rounded-[2rem] shadow-2xl overflow-hidden border border-slate-200">
        <div class="bg-blue-600 p-8 text-white text-center">
            <h1 class="text-2xl font-black italic tracking-tighter uppercase">Basecamp Coffee</h1>
            <p class="text-[10px] opacity-80 uppercase tracking-widest mt-1 font-bold">H2H Qiospay System</p>
        </div>

        <form action="api/proses_bayar.php" method="POST" class="p-8 space-y-6">
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 tracking-widest">Nomor HP Tujuan</label>
                <input type="number" name="nomor_hp" placeholder="08xxxxxxxxxx" required
                    class="w-full p-4 bg-slate-50 border-2 border-slate-100 focus:border-blue-500 rounded-2xl outline-none font-bold text-xl tracking-wider">
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-3 tracking-widest">Pilih Produk</label>
                <div class="space-y-3">
                    <div class="relative">
                        <input type="radio" name="sku" value="GPY1" id="gpy1" class="hidden" required>
                        <label for="gpy1" class="flex items-center justify-between p-4 border-2 border-slate-100 rounded-2xl cursor-pointer hover:bg-slate-50">
                            <span class="font-bold">Gopay 1.000</span>
                            <span class="text-xs font-black text-slate-400">Rp 2.050</span>
                        </label>
                    </div>
                    <div class="relative">
                        <input type="radio" name="sku" value="DANA1" id="dana1" class="hidden">
                        <label for="dana1" class="flex items-center justify-between p-4 border-2 border-slate-100 rounded-2xl cursor-pointer hover:bg-slate-50">
                            <span class="font-bold">Dana 1.000</span>
                            <span class="text-xs font-black text-slate-400">Rp 2.000</span>
                        </label>
                    </div>
                </div>
            </div>

            <button type="submit" 
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-5 rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg shadow-blue-100 transition-all active:scale-95">
                Proses Sekarang
            </button>
        </form>
    </div>
</body>
</html>
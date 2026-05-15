<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basecamp Coffee - Topup</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        input:checked + label {
            border-color: #2563eb;
            background-color: #eff6ff;
            transform: scale(1.02);
        }
    </style>
</head>
<body class="bg-slate-900 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md bg-slate-800 rounded-[2.5rem] shadow-2xl border border-slate-700 overflow-hidden">
        <div class="bg-blue-600 p-8 text-white text-center">
            <h1 class="text-2xl font-black italic tracking-tighter">BASECAMP COFFEE</h1>
            <p class="text-[10px] opacity-70 uppercase tracking-[0.3em] mt-1">Automatic Payment System</p>
        </div>

        <form action="api/proses_bayar.php" method="POST" class="p-8 space-y-8">
            
            <div>
                <label class="block text-[10px] font-black text-slate-500 uppercase mb-3 ml-1 tracking-widest">Nomor Tujuan</label>
                <input type="number" name="nomor_hp" placeholder="08xxxxxxxxxx" required
                    class="w-full p-5 bg-slate-900 border-2 border-slate-700 focus:border-blue-500 text-white rounded-2xl outline-none transition-all font-bold text-xl tracking-widest placeholder:text-slate-700">
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-500 uppercase mb-4 ml-1 tracking-widest">Pilih Produk</label>
                <div class="grid grid-cols-1 gap-4">
                    
                    <div class="relative">
                        <input type="radio" name="sku" value="GPY1" id="gpy1" class="hidden" required>
                        <label for="gpy1" class="flex items-center justify-between p-5 border-2 border-slate-700 rounded-2xl cursor-pointer hover:border-slate-500 transition-all text-white">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-bold opacity-40 uppercase">Gopay</span>
                                <span class="text-lg font-black tracking-tighter text-blue-400">Gopay 1.000</span>
                            </div>
                            <span class="font-black text-sm text-slate-400 italic">Rp 2.050</span>
                        </label>
                    </div>

                    <div class="relative">
                        <input type="radio" name="sku" value="DANA1" id="dana1" class="hidden">
                        <label for="dana1" class="flex items-center justify-between p-5 border-2 border-slate-700 rounded-2xl cursor-pointer hover:border-slate-500 transition-all text-white">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-bold opacity-40 uppercase">Dana</span>
                                <span class="text-lg font-black tracking-tighter text-blue-400">Dana 1.000</span>
                            </div>
                            <span class="font-black text-sm text-slate-400 italic">Rp 2.000</span>
                        </label>
                    </div>

                </div>
            </div>

            <button type="submit" 
                class="w-full bg-blue-600 hover:bg-blue-500 text-white py-6 rounded-2xl font-black text-xs uppercase tracking-[0.3em] shadow-xl shadow-blue-900/50 transition-all active:scale-95">
                Proses Sekarang
            </button>

            <div class="pt-2 text-center">
                <p class="text-[9px] text-slate-600 font-bold uppercase tracking-widest">Sengkuni Net & PT FAMILI</p>
            </div>
        </form>
    </div>

</body>
</html>
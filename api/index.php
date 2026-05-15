<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warung Basecamp Coffee</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        input:checked + label {
            border-color: #2563eb;
            background-color: #eff6ff;
            color: #1e40af;
        }
    </style>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden">
        <div class="bg-blue-600 p-6 text-white text-center">
            <h1 class="text-2xl font-black italic tracking-tighter">BASECAMP COFFEE</h1>
            <p class="text-xs opacity-80 uppercase tracking-widest mt-1">Topup Otomatis Qiospay</p>
        </div>

        <form action="api/proses_bayar.php" method="POST" class="p-6 space-y-6">
            
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2 ml-1">Nomor Tujuan (HP/Dana/Gopay)</label>
                <input type="number" name="nomor_hp" placeholder="08xxxxxxxxxx" required
                    class="w-full p-4 bg-slate-100 border-2 border-transparent focus:border-blue-500 focus:bg-white rounded-2xl outline-none transition-all font-bold text-lg">
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-3 ml-1">Pilih Nominal</label>
                <div class="grid grid-cols-2 gap-3">
                    
                    <div class="relative">
                        <input type="radio" name="sku" value="GPY1" id="gpy1" class="hidden" required>
                        <label for="gpy1" class="flex flex-col items-center justify-center p-4 border-2 border-slate-100 rounded-2xl cursor-pointer hover:bg-slate-50 transition-all">
                            <span class="text-[10px] font-bold opacity-50 uppercase">Gopay</span>
                            <span class="text-lg font-black">1.950</span>
                        </label>
                    </div>

                    <div class="relative">
                        <input type="radio" name="sku" value="DANA1" id="dana1" class="hidden">
                        <label for="dana1" class="flex flex-col items-center justify-center p-4 border-2 border-slate-100 rounded-2xl cursor-pointer hover:bg-slate-50 transition-all">
                            <span class="text-[10px] font-bold opacity-50 uppercase">Dana</span>
                            <span class="text-lg font-black">1.000</span>
                        </label>
                    </div>

                </div>
            </div>

            <button type="submit" 
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-5 rounded-2xl font-black text-sm uppercase tracking-widest shadow-lg shadow-blue-200 transition-all active:scale-95">
                Bayar Sekarang
            </button>

            <p class="text-center text-[9px] text-slate-300 uppercase font-bold tracking-tighter">Powered by PT FAMILI - Qiospay H2H</p>
        </form>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basecamp Coffee - Top Up</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap');
        body { font-family: 'Inter', sans-serif; }
        input:checked + label {
            border-color: #00b894;
            background-color: #f0fff4;
            color: #00816a;
        }
    </style>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-200">
        <div class="bg-[#00b894] p-8 text-white text-center">
            <h1 class="text-2xl font-black italic tracking-tighter">BASECAMP TOPUP</h1>
            <p class="text-[10px] opacity-90 uppercase tracking-[0.2em] mt-1 font-bold">Jalur OkeConnect OK2302353</p>
        </div>

        <form action="api/proses_bayar.php" method="POST" class="p-8 space-y-8">
            
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 ml-1 tracking-widest">Nomor HP Tujuan</label>
                <input type="number" name="nomor_hp" placeholder="08xxxxxxxxxx" required
                    class="w-full p-5 bg-slate-50 border-2 border-slate-100 focus:border-[#00b894] focus:bg-white rounded-2xl outline-none transition-all font-black text-xl tracking-wider text-slate-700">
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-4 ml-1 tracking-widest">Pilih Layanan</label>
                <div class="grid grid-cols-1 gap-4">
                    
                    <div class="relative">
                        <input type="radio" name="sku" value="GPY1" id="gpy1" class="hidden" required>
                        <label for="gpy1" class="flex items-center justify-between p-5 border-2 border-slate-100 rounded-2xl cursor-pointer hover:bg-slate-50 transition-all font-bold">
                            <div class="flex flex-col">
                                <span class="text-[10px] uppercase opacity-50">Gopay</span>
                                <span class="text-lg">1.000</span>
                            </div>
                            <span class="text-[#00b894] font-black">Rp 2.050</span>
                        </label>
                    </div>

                    <div class="relative opacity-50">
                        <input type="radio" name="sku" value="DANA1" id="dana1" class="hidden">
                        <label for="dana1" class="flex items-center justify-between p-5 border-2 border-slate-100 rounded-2xl cursor-pointer hover:bg-slate-50 transition-all font-bold">
                            <div class="flex flex-col">
                                <span class="text-[10px] uppercase opacity-50">Dana</span>
                                <span class="text-lg">1.000</span>
                            </div>
                            <span class="text-slate-400 font-black">Rp 2.000</span>
                        </label>
                    </div>

                </div>
            </div>

            <button type="submit" 
                class="w-full bg-[#00b894] hover:bg-[#00a383] text-white py-6 rounded-2xl font-black text-sm uppercase tracking-[0.2em] shadow-xl shadow-green-100 transition-all active:scale-95">
                Beli Sekarang
            </button>

            <div class="pt-4 border-t border-slate-100 text-center">
                <p class="text-[9px] text-slate-300 uppercase font-black tracking-widest">Sengkuni Net & PT FAMILI</p>
            </div>
        </form>
    </div>

</body>
</html>
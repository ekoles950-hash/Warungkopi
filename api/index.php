<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basecamp Coffee - Payment</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap');
        body { font-family: 'Inter', sans-serif; }
        input:checked + label {
            border-color: #3b82f6;
            background-color: #eff6ff;
        }
    </style>
</head>
<body class="bg-[#0f172a] flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-slate-200">
        <div class="bg-blue-600 p-8 text-white text-center">
            <h1 class="text-2xl font-black italic tracking-tighter uppercase">Basecamp Coffee</h1>
            <p class="text-[10px] opacity-80 uppercase tracking-widest mt-1 font-bold">H2H Payment System</p>
        </div>

        <form action="api/proses_bayar.php" method="POST" class="p-8 space-y-6">
            
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 tracking-widest ml-1">Nomor Tujuan</label>
                <input type="number" name="nomor_hp" placeholder="08xxxxxxxxxx" required
                    class="w-full p-5 bg-slate-50 border-2 border-slate-100 focus:border-blue-500 rounded-2xl outline-none font-bold text-xl tracking-wider text-slate-700">
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-3 tracking-widest ml-1">Pilih Produk</label>
                <div class="space-y-3">
                    
                    <div class="relative">
                        <input type="radio" name="sku" value="GPY1" id="gpy1" class="hidden" required>
                        <label for="gpy1" class="flex items-center justify-between p-5 border-2 border-slate-100 rounded-2xl cursor-pointer hover:bg-slate-50 transition-all">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-bold text-slate-400 uppercase">Gopay</span>
                                <span class="font-black text-slate-800">Gopay 1.000</span>
                            </div>
                            <span class="text-xs font-black text-blue-600">Rp 2.050</span>
                        </label>
                    </div>

                    <div class="relative">
                        <input type="radio" name="sku" value="DANA1" id="dana1" class="hidden">
                        <label for="dana1" class="flex items-center justify-between p-5 border-2 border-slate-100 rounded-2xl cursor-pointer hover:bg-slate-50 transition-all">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-bold text-slate-400 uppercase">Dana</span>
                                <span class="font-black text-slate-800">Dana 1.000</span>
                            </div>
                            <span class="text-xs font-black text-blue-600">Rp 2.000</span>
                        </label>
                    </div>

                </div>
            </div>

            <button type="submit" 
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-6 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-blue-100 transition-all active:scale-95">
                Bayar Sekarang
            </button>

            <div class="text-center pt-2">
                <p class="text-[9px] text-slate-300 font-bold uppercase tracking-widest">Sengkuni Net - PT FAMILI</p>
            </div>
        </form>
    </div>

</body>
</html>
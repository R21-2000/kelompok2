<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Dapur Mamina</title>
    {{-- Tailwind CSS & Font Awesome --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    {{-- Konfigurasi Warna --}}
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-orange': '#E37424',
                        'brand-orange-dark': '#C55A11',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Poppins', sans-serif; /* Opsional */ }
    </style>
</head>
<body class="bg-gray-100">

    <div class="flex h-screen">
        {{-- Sidebar --}}
        <aside class="w-64 flex flex-col bg-[#4A3728] text-white">
            <div class="h-20 flex items-center justify-center border-b border-white/10">
                {{-- Ganti dengan path logo Anda atau gunakan teks --}}
                <span class="text-xl font-bold">Dapur Mamina</span>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-1">
                <p class="px-4 text-xs text-gray-400 uppercase tracking-wider">Main</p>
                <a href="/dashboard" class="flex items-center px-4 py-2.5 rounded-lg font-semibold
                    {{ request()->is('dashboard') ? 'bg-brand-orange-dark' : 'hover:bg-white/10' }}">
                    <i class="fa-solid fa-chart-pie w-6 text-center mr-2"></i>
                    <span>Dashboard</span>
                </a>
                <a href="#" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-white/10">
                    <i class="fa-solid fa-cash-register w-6 text-center mr-2"></i>
                    <span>Kasir</span>
                </a>

                <p class="px-4 pt-4 text-xs text-gray-400 uppercase tracking-wider">Laporan</p>
                 <a href="/produk" class="flex items-center px-4 py-2.5 rounded-lg
                    {{ request()->is('produk*') ? 'bg-brand-orange-dark' : 'hover:bg-white/10' }}">
                    <i class="fa-solid fa-boxes-stacked w-6 text-center mr-2"></i>
                    <span>Produk</span>
                </a>

                <p class="px-4 pt-4 text-xs text-gray-400 uppercase tracking-wider">Inventori</p>
                <a href="#" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-white/10">
                     <i class="fa-solid fa-warehouse w-6 text-center mr-2"></i>
                    <span>Daftar Stok</span>
                </a>
                 <a href="#" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-white/10">
                    <i class="fa-solid fa-dolly w-6 text-center mr-2"></i>
                    <span>Masuk Stok</span>
                </a>
                <a href="#" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-white/10">
                    <i class="fa-solid fa-tasks w-6 text-center mr-2"></i>
                    <span>Opname Stok</span>
                </a>
            </nav>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col">
            <header class="h-20 bg-brand-orange flex items-center justify-end px-8">
                 <div class="bg-brand-orange-dark px-6 py-2 rounded-lg shadow-md">
                    <h1 class="text-xl font-bold text-white">@yield('header_title', 'Dashboard')</h1>
                </div>
            </header>

            <main class="flex-1 p-6 lg:p-8 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>
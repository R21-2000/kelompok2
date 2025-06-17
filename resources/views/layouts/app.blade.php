<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Menggunakan variabel $title untuk judul halaman --}}
    <title>{{ $title ?? 'Dashboard' }} - Dapur Mamina</title>
    {{-- Menggunakan CDN Tailwind CSS untuk kemudahan --}}
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Konfigurasi warna kustom Tailwind --}}
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-orange': '#E37424',
                        'brand-orange-dark': '#C55A11',
                        'brand-sidebar': '#3A3A3A',
                    }
                }
            }
        }
    </script>
    {{-- Font Awesome untuk ikon --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100">

    <div class="flex h-screen">
        {{-- Sidebar --}}
        <aside class="w-64 flex flex-col bg-[#4A3728] text-white">
            <div class="h-20 flex items-center justify-center border-b border-white/10">
                <img src="{{ asset('image/mamina.png') }}" alt="Logo Dapur Mamina" class="h-16 w-16 rounded-full">
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2">
                <p class="px-4 text-xs text-gray-400 uppercase tracking-wider">Main</p>
                {{-- Link Dashboard --}}
                <a href="{{ url('/') }}" class="flex items-center px-4 py-2.5 rounded-lg font-semibold
                    {{ request()->is('/') ? 'bg-brand-orange-dark/50' : 'hover:bg-white/10' }}">
                    <i class="fa-solid fa-chart-pie w-6 text-center"></i>
                    <span>Dashboard</span>
                </a>
                {{-- Link Kasir --}}
                <a href="{{ url('/kasir') }}" class="flex items-center px-4 py-2.5 rounded-lg
                    {{ request()->is('kasir') ? 'bg-brand-orange-dark/50 font-semibold' : 'hover:bg-white/10' }}">
                    <i class="fa-solid fa-cash-register w-6 text-center"></i>
                    <span>Kasir</span>
                </a>

                {{-- [UBAHAN] Mulai dari sini --}}
                <p class="px-4 pt-4 text-xs text-gray-400 uppercase tracking-wider">Laporan</p>
                
                <a href="{{ route('laporan') }}" class="flex items-center px-4 py-2.5 rounded-lg
                    {{ request()->is('laporan*') ? 'bg-brand-orange-dark/50 font-semibold' : 'hover:bg-white/10' }}">
                    <i class="fa-solid fa-file-alt w-6 text-center"></i>
                    <span>Laporan</span>
                </a>


                <p class="px-4 pt-4 text-xs text-gray-400 uppercase tracking-wider">Master Data</p>
                 {{-- Link Produk (dipindahkan ke sini) --}}
                 <a href="{{ route('produk.index') }}" class="flex items-center px-4 py-2.5 rounded-lg
                    {{ request()->is('produk*') || request()->is('tambah-produk') ? 'bg-brand-orange-dark/50 font-semibold' : 'hover:bg-white/10' }}">
                    <i class="fa-solid fa-tags w-6 text-center"></i>
                    <span>Produk</span>
                </a>

                {{-- Link Satuan (dipindahkan ke sini) --}}
                <a href="{{ route('satuan.index') }}" class="flex items-center px-4 py-2.5 rounded-lg
                    {{ request()->routeIs('satuan.*') ? 'bg-brand-orange-dark/50 font-semibold' : 'hover:bg-white/10' }}">
                    <i class="fa-solid fa-box-open w-6 text-center"></i>
                    <span>Satuan</span>
                </a>

                <p class="px-4 pt-4 text-xs text-gray-400 uppercase tracking-wider">Inventori</p>
                {{-- Link Daftar Stok --}}
                <a href="{{ url('/daftar-stok') }}" class="flex items-center px-4 py-2.5 rounded-lg
                    {{ request()->is('daftar-stok') || request()->is('opname-stok') ? 'bg-brand-orange-dark/50 font-semibold' : 'hover:bg-white/10' }}">
                    <i class="fa-solid fa-boxes-stacked w-6 text-center"></i>
                    <span>Daftar Stok</span>
                </a>
                {{-- Link Tambah Stok --}}
                <a href="{{ route('stok.create') }}" class="flex items-center px-4 py-2.5 rounded-lg
                    {{ request()->routeIs('stok.create') || request()->routeIs('stok.masuk') ? 'bg-brand-orange-dark/50 font-semibold' : 'hover:bg-white/10' }}">
                    <i class="fa-solid fa-dolly w-6 text-center"></i>
                    <span>Tambah Stok</span>
                </a>

                {{-- Link Opname Stok --}}
                <a href="{{ url('/opname-stok') }}" class="flex items-center px-4 py-2.5 rounded-lg
                    {{ request()->is('opname-stok') ? 'bg-brand-orange-dark/50 font-semibold' : 'hover:bg-white/10' }}">
                    <i class="fa-solid fa-tasks w-6 text-center"></i>
                    <span>Opname Stok</span>
                </a>
            </nav>

            <div class="h-16 bg-[#2c2016]">
                {{-- Footer Sidebar --}}
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col">
            <header class="h-20 bg-brand-orange flex items-center justify-end px-8">
                 <div class="bg-brand-orange-dark px-6 py-2 rounded-lg shadow-md">
                    <h1 class="text-xl font-bold text-white">{{ $header_title ?? 'Dashboard' }}</h1>
                </div>
            </header>

            <main class="flex-1 p-6 lg:p-8 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- [BARU] Script untuk Dropdown Sidebar --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const laporanBtn = document.getElementById('laporan-btn');
            const laporanSubmenu = document.getElementById('laporan-submenu');
            const laporanChevron = document.getElementById('laporan-chevron');

            laporanBtn.addEventListener('click', function() {
                // Toggle (tampilkan/sembunyikan) submenu
                laporanSubmenu.classList.toggle('hidden');
                // Putar ikon panah
                laporanChevron.classList.toggle('rotate-180');
            });
        });
    </script>
</body>
</html>
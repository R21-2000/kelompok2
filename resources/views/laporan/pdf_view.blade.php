<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .align-top {
            vertical-align: top;
        }
        ul {
            padding-left: 20px;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Laporan Penjualan</h1>
        <table>
            <thead>
                <tr>
                    <th>No Transaksi</th>
                    <th>Waktu Transaksi</th>
                    <th class="text-center">Total Kuantitas</th>
                    <th>Barang yang Dibeli</th>
                    <th>Total Penjualan</th>
                    <th>Metode Pembayaran</th>
                    <th>Nama Pelanggan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($penjualans as $penjualan)
                    <tr>
                        <td class="align-top">{{ $penjualan->no_transaksi }}</td>
                        <td class="align-top">{{ \Carbon\Carbon::parse($penjualan->waktu_bayar)->format('d M Y, H:i') }}</td>
                        <td class="text-center align-top">{{ $penjualan->penjualanDetails->sum('qty') }}</td>
                        <td class="align-top">
                            <ul>
                                @foreach ($penjualan->penjualanDetails as $detail)
                                    <li>
                                        {{ $detail->produk->nama_produk ?? 'Produk Dihapus' }}
                                        ({{ $detail->qty }} pcs)
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="align-top">Rp {{ number_format($penjualan->penjualanDetails->sum('subtotal'), 0, ',', '.') }}</td>
                        <td class="align-top">{{ $penjualan->metode_pembayaran }}</td>
                        <td class="align-top">{{ $penjualan->nama_pelanggan }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">
                            Tidak ada data transaksi yang cocok dengan filter yang diterapkan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
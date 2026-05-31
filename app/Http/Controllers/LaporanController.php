<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $dari = $request->dari ?? date('Y-m-01');
        $sampai = $request->sampai ?? date('Y-m-d');

        $transaksi = Transaksi::with('barang')
            ->whereBetween('tanggal', [$dari, $sampai])
            ->latest()
            ->get();

        $totalPendapatan = $transaksi->sum('total_harga');
        $totalTransaksi = $transaksi->count();

        // Grafik per hari
        $grafikHarian = $transaksi->groupBy('tanggal')->map(function($item) {
            return $item->sum('total_harga');
        });

        $grafikLabel = $grafikHarian->keys()->map(function($tgl) {
            return \Carbon\Carbon::parse($tgl)->format('d/m/Y');
        })->values();

        $grafikData = $grafikHarian->values();

        // Grafik per bulan
        $grafikBulanan = Transaksi::selectRaw('DATE_FORMAT(tanggal, "%Y-%m") as bulan, SUM(total_harga) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $grafikBulanLabel = $grafikBulanan->map(function($item) {
            return \Carbon\Carbon::parse($item->bulan)->format('M Y');
        })->values();

        $grafikBulanData = $grafikBulanan->pluck('total')->values();

        return view('laporan.index', compact(
            'transaksi',
            'totalPendapatan',
            'totalTransaksi',
            'dari',
            'sampai',
            'grafikLabel',
            'grafikData',
            'grafikBulanLabel',
            'grafikBulanData'
        ));
    }
}
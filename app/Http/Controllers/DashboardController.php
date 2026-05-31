<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\User;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = Barang::count();
        $totalKategori = Kategori::count();
        $totalUser = User::count();
        $totalTransaksi = Transaksi::count();
        $barangTerbaru = Barang::with('kategori')->latest()->take(5)->get();

        return view('dashboard', compact('totalBarang', 'totalKategori', 'totalUser', 'totalTransaksi', 'barangTerbaru'));
    }
}
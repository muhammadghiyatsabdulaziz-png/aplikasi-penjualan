<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Barang;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with('barang')->latest()->get();
        return view('transaksi.index', ['data' => $transaksi]);
    }

    public function tambah()
    {
        $barang = Barang::all();
        return view('transaksi.form', ['barang' => $barang]);
    }

    public function simpan(Request $request)
    {
        $barang = Barang::find($request->id_barang);

        // Validasi stok
        if ($request->jumlah > $barang->jumlah) {
            return redirect()->back()->with('error', 'Stok tidak cukup! Stok tersedia: ' . $barang->jumlah);
        }

        // Validasi stok tidak boleh 0
        if ($barang->jumlah == 0) {
            return redirect()->back()->with('error', 'Stok barang habis!');
        }

        $data = [
            'kode_transaksi' => 'TRX' . date('YmdHis'),
            'id_barang'      => $request->id_barang,
            'jumlah'         => $request->jumlah,
            'total_harga'    => $barang->harga * $request->jumlah,
            'tanggal'        => $request->tanggal,
        ];

        // Kurangi stok barang
        $barang->jumlah -= $request->jumlah;
        $barang->save();

        Transaksi::create($data);

        return redirect()->route('transaksi')->with('success', 'Transaksi berhasil disimpan!');
    }

    public function hapus($id)
    {
        $transaksi = Transaksi::find($id);
        if ($transaksi) {
            $transaksi->delete();
        }
        return redirect()->route('transaksi');
    }
}
@extends('layouts.app')

@section('title', 'Data Transaksi')

@section('contents')
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Data Transaksi</h6>
    </div>
    <div class="card-body">
      <a href="{{ route('transaksi.tambah') }}" class="btn btn-primary mb-3">Tambah Transaksi</a>
      <div class="table-responsive">
        <table class="table table-bordered" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Kode Transaksi</th>
              <th>Barang</th>
              <th>Jumlah</th>
              <th>Total Harga</th>
              <th>Tanggal</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @php($no = 1)
            @foreach ($data as $row)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $row->kode_transaksi }}</td>
                <td>{{ $row->barang?->nama_barang ?? '-' }}</td>
                <td>{{ $row->jumlah }}</td>
                <td>Rp {{ number_format($row->total_harga, 0, ',', '.') }}</td>
                <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d/m/Y') }}</td>
                <td>
                  <a href="{{ route('transaksi.hapus', $row->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus transaksi ini?')">Hapus</a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
@extends('layouts.app')

@section('title', 'Form Transaksi')

@section('contents')
  <form action="{{ route('transaksi.tambah.simpan') }}" method="post">
    @csrf
    <div class="row">
      <div class="col-12">
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Transaksi</h6>
          </div>
          <div class="card-body">

            @if(session('error'))
            <div class="alert alert-danger">
              {{ session('error') }}
            </div>
            @endif

            <div class="form-group">
              <label>Barang</label>
              <select name="id_barang" class="custom-select" required>
                <option value="" selected disabled hidden>-- Pilih Barang --</option>
                @foreach ($barang as $row)
                  <option value="{{ $row->id }}">{{ $row->nama_barang }} - Rp {{ number_format($row->harga, 0, ',', '.') }} (Stok: {{ $row->jumlah }})</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Jumlah</label>
              <input type="number" class="form-control" name="jumlah" placeholder="Jumlah beli..." min="1" required>
            </div>
            <div class="form-group">
              <label>Tanggal</label>
              <input type="date" class="form-control" name="tanggal" value="{{ date('Y-m-d') }}" required>
            </div>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('transaksi') }}" class="btn btn-secondary">Batal</a>
          </div>
        </div>
      </div>
    </div>
  </form>
@endsection
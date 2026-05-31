@extends('layouts.app')

@section('title', 'Laporan Penjualan')

@section('contents')
  <!-- Filter Tanggal -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Filter Laporan</h6>
    </div>
    <div class="card-body">
      <form method="GET" action="{{ route('laporan') }}">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label>Dari Tanggal</label>
              <input type="date" class="form-control" name="dari" value="{{ $dari }}">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Sampai Tanggal</label>
              <input type="date" class="form-control" name="sampai" value="{{ $sampai }}">
            </div>
          </div>
          <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary mb-3">Filter</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Card Total -->
  <div class="row">
    <div class="col-md-6">
      <div class="card border-left-success shadow mb-4">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Pendapatan</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card border-left-primary shadow mb-4">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Transaksi</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalTransaksi }} Transaksi</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Grafik Per Hari -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Grafik Penjualan Per Hari</h6>
    </div>
    <div class="card-body">
      @if(count($grafikLabel) > 0)
        <canvas id="grafikHarian" height="80"></canvas>
      @else
        <p class="text-center text-gray-500">Tidak ada data transaksi pada periode ini.</p>
      @endif
    </div>
  </div>

  <!-- Grafik Per Bulan -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Grafik Penjualan Per Bulan</h6>
    </div>
    <div class="card-body">
      @if(count($grafikBulanLabel) > 0)
        <canvas id="grafikBulanan" height="80"></canvas>
      @else
        <p class="text-center text-gray-500">Tidak ada data transaksi.</p>
      @endif
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
  <script>
    @if(count($grafikLabel) > 0)
    new Chart(document.getElementById('grafikHarian'), {
      type: 'bar',
      data: {
        labels: @json($grafikLabel),
        datasets: [{
          label: 'Total Pendapatan (Rp)',
          data: @json($grafikData),
          backgroundColor: 'rgba(78, 115, 223, 0.7)',
          borderColor: 'rgba(78, 115, 223, 1)',
          borderWidth: 1,
          borderRadius: 6,
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { display: true },
          tooltip: {
            callbacks: {
              label: function(context) {
                return 'Rp ' + context.raw.toLocaleString('id-ID');
              }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(value) {
                return 'Rp ' + value.toLocaleString('id-ID');
              }
            }
          }
        }
      }
    });
    @endif

    @if(count($grafikBulanLabel) > 0)
    new Chart(document.getElementById('grafikBulanan'), {
      type: 'bar',
      data: {
        labels: @json($grafikBulanLabel),
        datasets: [{
          label: 'Total Pendapatan Per Bulan (Rp)',
          data: @json($grafikBulanData),
          backgroundColor: 'rgba(28, 200, 138, 0.7)',
          borderColor: 'rgba(28, 200, 138, 1)',
          borderWidth: 1,
          borderRadius: 6,
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { display: true },
          tooltip: {
            callbacks: {
              label: function(context) {
                return 'Rp ' + context.raw.toLocaleString('id-ID');
              }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(value) {
                return 'Rp ' + value.toLocaleString('id-ID');
              }
            }
          }
        }
      }
    });
    @endif
  </script>
@endsection
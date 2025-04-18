@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">Selamat Datang di Sistem Pakar HVAS</h4>
                <p class="card-category">Dashboard {{ ucfirst(auth()->user()->role->name) }}</p>
            </div>
            <div class="card-body">
                <p>Selamat datang, <strong>{{ auth()->user()->name }}</strong>!</p>

                <p>Sistem Pakar Identifikasi Kesalahan High Volume Air Sampler (HVAS) adalah aplikasi yang membantu Anda mengidentifikasi kerusakan pada perangkat HVAS berdasarkan gejala-gejala yang terlihat.</p>

                <div class="alert alert-info">
                    <h4>Akses Cepat</h4>
                    <div class="row mt-4">
                        @if(auth()->user()->isAdmin())
                            <div class="col-md-3">
                                <a href="{{ route('users.index') }}" class="btn btn-lg btn-block btn-danger">
                                    <i class="material-icons">people</i> Kelola Pengguna
                                </a>
                            </div>
                        @endif

                        @if(auth()->user()->isAdmin() || auth()->user()->isTeknisi())
                            <div class="col-md-3">
                                <a href="{{ route('gejala.index') }}" class="btn btn-lg btn-block btn-info">
                                    <i class="material-icons">healing</i> Kelola Gejala
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('aturan.index') }}" class="btn btn-lg btn-block btn-warning">
                                    <i class="material-icons">rule</i> Kelola Aturan
                                </a>
                            </div>
                        @endif

                        <div class="col-md-3">
                            <a href="{{ route('diagnosa.index') }}" class="btn btn-lg btn-block btn-success">
                                <i class="material-icons">search</i> Mulai Diagnosa
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(auth()->user()->isAdmin() || auth()->user()->isTeknisi())
    <!-- Statistik dan Grafik untuk Admin dan Teknisi -->
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-header card-header-info">
                    <h4>{{ \App\Models\Gejala::count() }}</h4>
                </div>
                <div class="card-body">
                    <p>Total Gejala</p>
                </div>
                <div class="card-footer">
                    <a href="{{ route('gejala.index') }}">Kelola Gejala <i class="material-icons">arrow_forward</i></a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-header card-header-success">
                    <h4>{{ \App\Models\Kerusakan::count() }}</h4>
                </div>
                <div class="card-body">
                    <p>Total Kerusakan</p>
                </div>
                <div class="card-footer">
                    <a href="{{ route('kerusakan.index') }}">Kelola Kerusakan <i class="material-icons">arrow_forward</i></a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-header card-header-warning">
                    <h4>{{ \App\Models\Aturan::count() }}</h4>
                </div>
                <div class="card-body">
                    <p>Total Aturan</p>
                </div>
                <div class="card-footer">
                    <a href="{{ route('aturan.index') }}">Kelola Aturan <i class="material-icons">arrow_forward</i></a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4>{{ \App\Models\Konsultasi::count() }}</h4>
                </div>
                <div class="card-body">
                    <p>Total Konsultasi</p>
                </div>
                <div class="card-footer">
                    <a href="#">Lihat Detail <i class="material-icons">arrow_forward</i></a>
                </div>
            </div>
        </div>
    </div>
@else
    <!-- Informasi untuk User Biasa -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header card-header-success">
                    <h4 class="card-title">Petunjuk Penggunaan</h4>
                </div>
                <div class="card-body">
                    <ol>
                        <li>Klik menu <strong>Diagnosa</strong> pada sidebar untuk mulai konsultasi</li>
                        <li>Pilih gejala-gejala yang Anda temui pada HVAS</li>
                        <li>Sistem akan menganalisis dan memberikan hasil diagnosa</li>
                        <li>Lihat riwayat konsultasi Anda di menu <strong>Riwayat Konsultasi</strong></li>
                        <li>Gunakan fitur <strong>Predictive Maintenance</strong> untuk memprediksi kapan kerusakan berikutnya akan terjadi</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header card-header-info">
                    <h4 class="card-title">Riwayat Konsultasi Terbaru</h4>
                </div>
                <div class="card-body">
                    @php
                        $konsultasis = \App\Models\Konsultasi::where('user_id', auth()->id())
                            ->orderBy('tanggal', 'desc')
                            ->limit(5)
                            ->get();
                    @endphp

                    @if($konsultasis->isEmpty())
                        <div class="alert alert-info">
                            Anda belum memiliki riwayat konsultasi. Silakan lakukan diagnosa terlebih dahulu.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Kerusakan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($konsultasis as $konsultasi)
                                        <tr>
                                            <td>{{ $konsultasi->tanggal->format('d M Y') }}</td>
                                            <td>
                                                @if($konsultasi->kerusakan)
                                                    {{ $konsultasi->kerusakan->nama }}
                                                @else
                                                    <span class="text-muted">Tidak ditemukan</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('riwayat.show', $konsultasi->id) }}" class="btn btn-sm btn-info">
                                                    <i class="material-icons">visibility</i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-right mt-3">
                            <a href="{{ route('riwayat.index') }}" class="btn btn-primary">
                                Lihat Semua <i class="material-icons">arrow_forward</i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif

@if(auth()->user()->isAdmin() || auth()->user()->isTeknisi())
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-warning">
                    <h4 class="card-title">Tren Kerusakan</h4>
                    <p class="card-category">Grafik tren kerusakan dalam 6 bulan terakhir</p>
                </div>
                <div class="card-body">
                    <div style="height: 300px;">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection

@if(auth()->user()->isAdmin() || auth()->user()->isTeknisi())
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil data kerusakan 6 bulan terakhir
        @php
        $months = [];
        $counts = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = \Carbon\Carbon::now()->subMonths($i);
            $count = \App\Models\Konsultasi::whereMonth('tanggal', $month->month)
                ->whereYear('tanggal', $month->year)
                ->whereNotNull('kerusakan_id')
                ->count();

            $months[] = $month->isoFormat('MMMM Y');
            $counts[] = $count;
        }
        @endphp

        const months = @json($months);
        const counts = @json($counts);

        // Buat chart
        const ctx = document.getElementById('trendChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Jumlah Kerusakan',
                    data: counts,
                    backgroundColor: 'rgba(255, 152, 0, 0.2)',
                    borderColor: 'rgba(255, 152, 0, 1)',
                    borderWidth: 2,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
@endif

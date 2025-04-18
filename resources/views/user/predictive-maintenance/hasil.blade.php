@extends('layouts.user')

@section('title', 'Hasil Predictive Maintenance')
@section('page-title', 'Hasil Predictive Maintenance')

@section('styles')
<style>
    .big-number {
        font-size: 3rem;
        font-weight: bold;
        color: #ff9800;
    }
    .unit {
        font-size: 1.2rem;
    }
    .timeline {
        position: relative;
        padding: 20px 0;
    }
    .timeline::before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        width: 4px;
        background: #ddd;
        left: 50%;
        margin-left: -2px;
    }
    .timeline-item {
        position: relative;
        margin-bottom: 30px;
    }
    .timeline-item::after {
        content: '';
        display: table;
        clear: both;
    }
    .timeline-content {
        position: relative;
        width: 45%;
        padding: 10px 15px;
        border-radius: 5px;
        background: #fff;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .timeline-date {
        font-weight: bold;
        margin-bottom: 5px;
    }
    .timeline-dot {
        position: absolute;
        width: 16px;
        height: 16px;
        left: 50%;
        top: 10px;
        margin-left: -8px;
        border-radius: 50%;
        background: #ff9800;
        z-index: 10;
    }
    .timeline-left {
        float: left;
    }
    .timeline-right {
        float: right;
    }
    .timeline-future {
        background: #e8f5e9;
        border-left: 4px solid #4caf50;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-warning">
                <h4 class="card-title">Hasil Predictive Maintenance</h4>
                <p class="card-category">
                    Komponen: {{ $hasil['komponen'] }}
                </p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header card-header-info">
                                <h4 class="card-title">Mean Time Between Failure (MTBF)</h4>
                            </div>
                            <div class="card-body text-center">
                                <p>Rata-rata waktu antar kerusakan komponen</p>
                                <div class="big-number">
                                    {{ round($hasil['mtbf']) }} <span class="unit">hari</span>
                                </div>
                                <p class="mt-3">
                                    MTBF dihitung berdasarkan {{ count($hasil['riwayat_tanggal']) }} kali kerusakan terdahulu
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header card-header-success">
                                <h4 class="card-title">Prediksi Kerusakan Berikutnya</h4>
                            </div>
                            <div class="card-body text-center">
                                <p>Perkiraan tanggal kerusakan berikutnya terjadi</p>
                                <div class="big-number">
                                    {{ \Carbon\Carbon::parse($hasil['prediksi_kerusakan'])->format('d M Y') }}
                                </div>
                                <p class="mt-3">
                                    @php
                                        $today = \Carbon\Carbon::now();
                                        $predictionDate = \Carbon\Carbon::parse($hasil['prediksi_kerusakan']);
                                        $diff = $today->diffInDays($predictionDate, false);
                                    @endphp

                                    @if($diff < 0)
                                        <span class="text-danger">Sudah melewati {{ abs($diff) }} hari dari jadwal perawatan!</span>
                                    @elseif($diff == 0)
                                        <span class="text-warning">Jadwal perawatan hari ini!</span>
                                    @elseif($diff <= 7)
                                        <span class="text-warning">{{ $diff }} hari lagi</span>
                                    @else
                                        <span class="text-success">{{ $diff }} hari lagi</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">Timeline Kerusakan</h4>
                            </div>
                            <div class="card-body">
                                <div class="timeline">
                                    @foreach($hasil['riwayat_tanggal'] as $index => $tanggal)
                                        <div class="timeline-item">
                                            <div class="timeline-dot"></div>
                                            <div class="timeline-content {{ $index % 2 == 0 ? 'timeline-left' : 'timeline-right' }}">
                                                <div class="timeline-date">Kerusakan {{ $index + 1 }}</div>
                                                <p>{{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}</p>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="timeline-item">
                                        <div class="timeline-dot"></div>
                                        <div class="timeline-content {{ count($hasil['riwayat_tanggal']) % 2 == 0 ? 'timeline-left' : 'timeline-right' }} timeline-future">
                                            <div class="timeline-date">Prediksi Kerusakan Berikutnya</div>
                                            <p>{{ \Carbon\Carbon::parse($hasil['prediksi_kerusakan'])->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12 text-center">
                        <a href="{{ route('predictive-maintenance.index') }}" class="btn btn-primary">
                            <i class="material-icons">refresh</i> Hitung Ulang
                        </a>
                        <button onclick="window.print()" class="btn btn-info">
                            <i class="material-icons">print</i> Cetak Hasil
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

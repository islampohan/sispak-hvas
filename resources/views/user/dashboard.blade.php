@extends('layouts.user')

@section('title', 'Dashboard User')
@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success">
                <h4 class="card-title">Selamat Datang di Sistem Pakar HVAS</h4>
                <p class="card-category">Dashboard Pengguna</p>
            </div>
            <div class="card-body">
                <p>Selamat datang, <strong>{{ auth()->user()->name }}</strong>!</p>

                <p>Sistem Pakar Identifikasi Kesalahan High Volume Air Sampler (HVAS) adalah aplikasi yang membantu Anda mengidentifikasi kerusakan pada perangkat HVAS berdasarkan gejala-gejala yang terlihat.</p>

                <div class="alert alert-info">
                    <h4>Akses Cepat</h4>
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <a href="{{ route('diagnosa.index') }}" class="btn btn-lg btn-block btn-primary">
                                <i class="material-icons">search</i> Mulai Diagnosa
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('riwayat.index') }}" class="btn btn-lg btn-block btn-info">
                                <i class="material-icons">history</i> Riwayat Konsultasi
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('predictive-maintenance.index') }}" class="btn btn-lg btn-block btn-warning">
                                <i class="material-icons">schedule</i> Predictive Maintenance
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">Petunjuk Penggunaan</h4>
            </div>
            <div class="card-body">
                <h5>Melakukan Diagnosa:</h5>
                <ol>
                    <li>Klik menu <strong>Diagnosa</strong> pada sidebar atau tombol Mulai Diagnosa di atas</li>
                    <li>Pilih gejala-gejala yang Anda temui pada HVAS dengan memberi centang</li>
                    <li>Klik tombol <strong>Proses Diagnosa</strong> untuk mendapatkan hasil</li>
                    <li>Sistem akan menampilkan kerusakan yang teridentifikasi beserta solusinya</li>
                </ol>

                <h5>Melihat Riwayat Konsultasi:</h5>
                <ol>
                    <li>Klik menu <strong>Riwayat Konsultasi</strong> pada sidebar</li>
                    <li>Lihat daftar konsultasi yang telah Anda lakukan</li>
                    <li>Klik tombol <strong>Detail</strong> untuk melihat hasil konsultasi</li>
                    <li>Anda dapat mengunduh hasil konsultasi dalam format PDF dengan klik tombol <strong>PDF</strong></li>
                </ol>

                <h5>Menggunakan Predictive Maintenance:</h5>
                <ol>
                    <li>Klik menu <strong>Predictive Maintenance</strong> pada sidebar</li>
                    <li>Pilih komponen dan masukkan tanggal-tanggal kerusakan sebelumnya</li>
                    <li>Klik tombol <strong>Hitung MTBF</strong> untuk mendapatkan prediksi</li>
                    <li>Sistem akan menampilkan perkiraan kapan kerusakan berikutnya akan terjadi</li>
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

        <div class="card mt-4">
            <div class="card-header card-header-warning">
                <h4 class="card-title">Informasi HVAS</h4>
            </div>
            <div class="card-body">
                <p>High Volume Air Sampler (HVAS) adalah perangkat yang digunakan untuk mengumpulkan sampel partikel udara dalam volume besar. Perangkat ini penting untuk pemantauan kualitas udara dan penelitian lingkungan.</p>

                <p>Beberapa komponen utama HVAS yang sering mengalami kerusakan:</p>
                <ul>
                    <li>Motor pompa</li>
                    <li>Filter dan penyaring</li>
                    <li>Sistem pengatur aliran</li>
                    <li>Panel kontrol</li>
                    <li>Sensor tekanan</li>
                </ul>

                <p>Perawatan rutin diperlukan untuk memastikan perangkat HVAS berfungsi dengan baik. Gunakan fitur <a href="{{ route('predictive-maintenance.index') }}">Predictive Maintenance</a> untuk memperkirakan waktu perawatan yang tepat.</p>
            </div>
        </div>
    </div>
</div>
@endsection

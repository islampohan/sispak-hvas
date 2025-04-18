@extends('layouts.user')

@section('title', 'Detail Riwayat Konsultasi')
@section('page-title', 'Detail Riwayat Konsultasi')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-info">
                <h4 class="card-title">Detail Konsultasi</h4>
                <p class="card-category">
                    Tanggal: {{ $konsultasi->tanggal->format('d M Y H:i') }}
                </p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header card-header-success">
                                <h4 class="card-title">Gejala yang Dipilih</h4>
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    @foreach($konsultasi->detailKonsultasis as $detail)
                                        <li class="list-group-item">
                                            <strong>{{ $detail->gejala->kode }}</strong> - {{ $detail->gejala->nama }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header card-header-danger">
                                <h4 class="card-title">Kerusakan Teridentifikasi</h4>
                            </div>
                            <div class="card-body">
                                @if($konsultasi->kerusakan)
                                    <h4>{{ $konsultasi->kerusakan->kode }} - {{ $konsultasi->kerusakan->nama }}</h4>
                                    <p>{{ $konsultasi->kerusakan->deskripsi }}</p>
                                @else
                                    <div class="alert alert-warning">
                                        Tidak ada kerusakan yang teridentifikasi.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-warning">
                                <h4 class="card-title">Solusi</h4>
                            </div>
                            <div class="card-body">
                                @if($konsultasi->kerusakan && $konsultasi->kerusakan->solusis->isNotEmpty())
                                    @foreach($konsultasi->kerusakan->solusis as $solusi)
                                        <h5>Deskripsi:</h5>
                                        <p>{{ $solusi->deskripsi }}</p>

                                        <h5>Langkah Perbaikan:</h5>
                                        <div class="p-3 bg-light rounded">
                                            {!! nl2br(e($solusi->langkah_perbaikan)) !!}
                                        </div>
                                    @endforeach
                                @else
                                    <div class="alert alert-warning">
                                        Belum ada solusi untuk kerusakan ini. Silakan hubungi teknisi.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12 text-center">
                        <a href="{{ route('riwayat.index') }}" class="btn btn-primary">
                            <i class="material-icons">arrow_back</i> Kembali
                        </a>
                        <a href="{{ route('riwayat.pdf', $konsultasi->id) }}" class="btn btn-success" target="_blank">
                            <i class="material-icons">picture_as_pdf</i> Unduh PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

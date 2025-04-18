@extends('layouts.user')

@section('title', 'Hasil Diagnosa')
@section('page-title', 'Hasil Diagnosa')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-info">
                <h4 class="card-title">Hasil Diagnosa</h4>
                <p class="card-category">Hasil diagnosa kesalahan HVAS berdasarkan gejala yang dipilih</p>
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
                                    @foreach($gejalas as $gejala)
                                        <li class="list-group-item">
                                            <strong>{{ $gejala->kode }}</strong> - {{ $gejala->nama }}
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
                                <h4>{{ $kerusakan->kode }} - {{ $kerusakan->nama }}</h4>
                                <p>{{ $kerusakan->deskripsi }}</p>
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
                                @if($solusi)
                                    <h5>Deskripsi:</h5>
                                    <p>{{ $solusi->deskripsi }}</p>

                                    <h5>Langkah Perbaikan:</h5>
                                    <div class="p-3 bg-light rounded">
                                        {!! nl2br(e($solusi->langkah_perbaikan)) !!}
                                    </div>
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
                        <a href="{{ route('diagnosa.index') }}" class="btn btn-primary mr-2">
                            <i class="material-icons">refresh</i> Diagnosa Baru
                        </a>
                        <a href="{{ route('riwayat.show', $konsultasi->id) }}" class="btn btn-info">
                            <i class="material-icons">history</i> Lihat di Riwayat
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

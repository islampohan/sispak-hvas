@extends('layouts.user')

@section('title', 'Riwayat Konsultasi')
@section('page-title', 'Riwayat Konsultasi')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-info">
                <h4 class="card-title">Daftar Riwayat Konsultasi</h4>
                <p class="card-category">Riwayat konsultasi diagnosa kesalahan HVAS</p>
            </div>
            <div class="card-body">
                @if($konsultasis->isEmpty())
                    <div class="alert alert-info">
                        Anda belum memiliki riwayat konsultasi. Silakan lakukan diagnosa terlebih dahulu.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="text-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Kerusakan</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($konsultasis as $index => $konsultasi)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $konsultasi->tanggal->format('d M Y H:i') }}</td>
                                        <td>
                                            @if($konsultasi->kerusakan)
                                                {{ $konsultasi->kerusakan->kode }} - {{ $konsultasi->kerusakan->nama }}
                                            @else
                                                <span class="text-muted">Tidak ditemukan</span>
                                            @endif
                                        </td>
                                        <td>{{ $konsultasi->keterangan }}</td>
                                        <td>
                                            <a href="{{ route('riwayat.show', $konsultasi->id) }}" class="btn btn-sm btn-info">
                                                <i class="material-icons">visibility</i> Detail
                                            </a>
                                            <a href="{{ route('riwayat.pdf', $konsultasi->id) }}" class="btn btn-sm btn-success" target="_blank">
                                                <i class="material-icons">picture_as_pdf</i> PDF
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

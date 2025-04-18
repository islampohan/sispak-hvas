@extends('layouts.teknisi')

@section('title', 'Detail Kerusakan')
@section('page-title', 'Detail Kerusakan')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">Informasi Kerusakan</h4>
                <p class="card-category">Detail informasi kerusakan pada HVAS</p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kode Kerusakan:</label>
                            <p>{{ $kerusakan->kode }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Kerusakan:</label>
                            <p>{{ $kerusakan->nama }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Deskripsi:</label>
                            <p>{{ $kerusakan->deskripsi ?: 'Tidak ada deskripsi' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h4 class="mt-4">Solusi Untuk Kerusakan Ini:</h4>
                        @if($kerusakan->solusis->isEmpty())
                            <div class="alert alert-warning">
                                Belum ada solusi untuk kerusakan ini.
                                <a href="{{ route('solusi.create', ['kerusakan_id' => $kerusakan->id]) }}" class="font-weight-bold">
                                    Tambahkan solusi
                                </a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="text-primary">
                                        <tr>
                                            <th>Deskripsi</th>
                                            <th>Langkah Perbaikan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($kerusakan->solusis as $solusi)
                                            <tr>
                                                <td>{{ Str::limit($solusi->deskripsi, 100) }}</td>
                                                <td>{{ Str::limit($solusi->langkah_perbaikan, 100) }}</td>
                                                <td>
                                                    <a href="{{ route('solusi.edit', $solusi->id) }}" class="btn btn-warning btn-sm">
                                                        <i class="material-icons">edit</i>
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

                <div class="row">
                    <div class="col-md-12">
                        <h4 class="mt-4">Digunakan dalam Aturan:</h4>
                        @if($kerusakan->aturans->isEmpty())
                            <div class="alert alert-info">
                                Kerusakan ini belum digunakan dalam aturan apapun.
                                <a href="{{ route('aturan.create', ['kerusakan_id' => $kerusakan->id]) }}" class="font-weight-bold">
                                    Tambahkan aturan
                                </a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="text-primary">
                                        <tr>
                                            <th>Kode Aturan</th>
                                            <th>Gejala</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($kerusakan->aturans as $aturan)
                                            <tr>
                                                <td>{{ $aturan->kode }}</td>
                                                <td>
                                                    <ul>
                                                        @foreach($aturan->gejalas as $gejala)
                                                            <li>{{ $gejala->kode }} - {{ $gejala->nama }}</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td>
                                                    <a href="{{ route('aturan.edit', $aturan->id) }}" class="btn btn-warning btn-sm">
                                                        <i class="material-icons">edit</i>
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

                <div class="form-group text-right">
                    <a href="{{ route('kerusakan.index') }}" class="btn btn-default">Kembali</a>
                    <a href="{{ route('kerusakan.edit', $kerusakan->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('kerusakan.destroy', $kerusakan->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kerusakan ini?')">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

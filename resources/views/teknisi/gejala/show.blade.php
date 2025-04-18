@extends('layouts.teknisi')

@section('title', 'Detail Gejala')
@section('page-title', 'Detail Gejala')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">Informasi Gejala</h4>
                <p class="card-category">Detail informasi gejala kesalahan HVAS</p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kode Gejala:</label>
                            <p>{{ $gejala->kode }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Gejala:</label>
                            <p>{{ $gejala->nama }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Deskripsi:</label>
                            <p>{{ $gejala->deskripsi ?: 'Tidak ada deskripsi' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h4 class="mt-4">Digunakan dalam Aturan:</h4>
                        @if($gejala->aturans->isEmpty())
                            <div class="alert alert-info">
                                Gejala ini belum digunakan dalam aturan apapun.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="text-primary">
                                        <tr>
                                            <th>Kode Aturan</th>
                                            <th>Kerusakan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($gejala->aturans as $aturan)
                                            <tr>
                                                <td>{{ $aturan->kode }}</td>
                                                <td>{{ $aturan->kerusakan->nama }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group text-right">
                    <a href="{{ route('gejala.index') }}" class="btn btn-default">Kembali</a>
                    <a href="{{ route('gejala.edit', $gejala->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('gejala.destroy', $gejala->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus gejala ini?')">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

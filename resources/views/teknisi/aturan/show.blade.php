@extends('layouts.teknisi')

@section('title', 'Detail Aturan')
@section('page-title', 'Detail Aturan')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">Informasi Aturan</h4>
                <p class="card-category">Detail informasi aturan sistem pakar HVAS</p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kode Aturan:</label>
                            <p>{{ $aturan->kode }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kerusakan:</label>
                            <p>{{ $aturan->kerusakan->kode }} - {{ $aturan->kerusakan->nama }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h4 class="mt-4">Gejala yang Terkait:</h4>
                        @if($aturan->gejalas->isEmpty())
                            <div class="alert alert-info">
                                Belum ada gejala terkait dengan aturan ini.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="text-primary">
                                        <tr>
                                            <th>Kode</th>
                                            <th>Nama Gejala</th>
                                            <th>Deskripsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($aturan->gejalas as $gejala)
                                            <tr>
                                                <td>{{ $gejala->kode }}</td>
                                                <td>{{ $gejala->nama }}</td>
                                                <td>{{ Str::limit($gejala->deskripsi, 100) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group text-right">
                    <a href="{{ route('aturan.index') }}" class="btn btn-default">Kembali</a>
                    <a href="{{ route('aturan.edit', $aturan->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('aturan.destroy', $aturan->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus aturan ini?')">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

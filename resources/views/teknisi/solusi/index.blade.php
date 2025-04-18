@extends('layouts.teknisi')

@section('title', 'Data Solusi')
@section('page-title', 'Data Solusi')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">Daftar Solusi</h4>
                <p class="card-category">Daftar solusi untuk kerusakan pada HVAS</p>
            </div>
            <div class="card-body">
                <div class="text-end mb-3">
                    <a href="{{ route('solusi.create') }}" class="btn btn-success">
                        <i class="material-icons">add</i> Tambah Solusi
                    </a>
                </div>

                @if($solusis->isEmpty())
                    <div class="alert alert-info">
                        Belum ada data solusi. Silakan tambahkan data solusi baru.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="text-primary">
                                <tr>
                                    <th>Kerusakan</th>
                                    <th>Deskripsi</th>
                                    <th>Langkah Perbaikan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($solusis as $solusi)
                                    <tr>
                                        <td>{{ $solusi->kerusakan->kode }} - {{ $solusi->kerusakan->nama }}</td>
                                        <td>{{ Str::limit($solusi->deskripsi, 50) }}</td>
                                        <td>{{ Str::limit($solusi->langkah_perbaikan, 50) }}</td>
                                        <td class="td-actions">
                                            <a href="{{ route('solusi.show', $solusi->id) }}" class="btn btn-info btn-sm">
                                                <i class="material-icons">visibility</i>
                                            </a>
                                            <a href="{{ route('solusi.edit', $solusi->id) }}" class="btn btn-warning btn-sm">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <form action="{{ route('solusi.destroy', $solusi->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus solusi ini?')">
                                                    <i class="material-icons">delete</i>
                                                </button>
                                            </form>
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

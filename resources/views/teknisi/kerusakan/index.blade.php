@extends('layouts.teknisi')

@section('title', 'Data Kerusakan')
@section('page-title', 'Data Kerusakan')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">Daftar Kerusakan</h4>
                <p class="card-category">Daftar kerusakan pada HVAS</p>
            </div>
            <div class="card-body">
                <div class="text-end mb-3">
                    <a href="{{ route('kerusakan.create') }}" class="btn btn-success">
                        <i class="material-icons">add</i> Tambah Kerusakan
                    </a>
                </div>

                @if($kerusakans->isEmpty())
                    <div class="alert alert-info">
                        Belum ada data kerusakan. Silakan tambahkan data kerusakan baru.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="text-primary">
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Kerusakan</th>
                                    <th>Deskripsi</th>
                                    <th>Jumlah Solusi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kerusakans as $kerusakan)
                                    <tr>
                                        <td>{{ $kerusakan->kode }}</td>
                                        <td>{{ $kerusakan->nama }}</td>
                                        <td>{{ Str::limit($kerusakan->deskripsi, 50) }}</td>
                                        <td>{{ $kerusakan->solusis->count() }}</td>
                                        <td class="td-actions">
                                            <a href="{{ route('kerusakan.show', $kerusakan->id) }}" class="btn btn-info btn-sm">
                                                <i class="material-icons">visibility</i>
                                            </a>
                                            <a href="{{ route('kerusakan.edit', $kerusakan->id) }}" class="btn btn-warning btn-sm">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <form action="{{ route('kerusakan.destroy', $kerusakan->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus kerusakan ini?')">
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

{{-- resources/views/teknisi/aturan/index.blade.php --}}
@extends('layouts.teknisi')

@section('title', 'Data Aturan')
@section('page-title', 'Data Aturan (Basis Pengetahuan)')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">Daftar Aturan</h4>
                <p class="card-category">Daftar aturan inferensi untuk diagnosa HVAS</p>
            </div>
            <div class="card-body">
                <div class="text-end mb-3">
                    <a href="{{ route('aturan.create') }}" class="btn btn-success">
                        <i class="material-icons">add</i> Tambah Aturan
                    </a>
                </div>

                @if($aturans->isEmpty())
                    <div class="alert alert-info">
                        Belum ada data aturan. Silakan tambahkan data aturan baru.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="text-primary">
                                <tr>
                                    <th>Kode</th>
                                    <th>Kerusakan</th>
                                    <th>Gejala</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($aturans as $aturan)
                                    <tr>
                                        <td>{{ $aturan->kode }}</td>
                                        <td>{{ $aturan->kerusakan->nama }}</td>
                                        <td>
                                            <ul>
                                                @foreach($aturan->gejalas as $gejala)
                                                    <li>{{ $gejala->kode }} - {{ $gejala->nama }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td class="td-actions">
                                            <a href="{{ route('aturan.show', $aturan->id) }}" class="btn btn-info btn-sm">
                                                <i class="material-icons">visibility</i>
                                            </a>
                                            <a href="{{ route('aturan.edit', $aturan->id) }}" class="btn btn-warning btn-sm">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <form action="{{ route('aturan.destroy', $aturan->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus aturan ini?')">
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

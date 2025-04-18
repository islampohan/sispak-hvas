@extends('layouts.teknisi')

@section('title', 'Data Gejala')
@section('page-title', 'Data Gejala')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">Daftar Gejala</h4>
                <p class="card-category">Daftar gejala kesalahan pada HVAS</p>
            </div>
            <div class="card-body">
                <div class="text-end mb-3">
                    <a href="{{ route('gejala.create') }}" class="btn btn-success">
                        <i class="material-icons">add</i> Tambah Gejala
                    </a>
                </div>

                @if($gejalas->isEmpty())
                    <div class="alert alert-info">
                        Belum ada data gejala. Silakan tambahkan data gejala baru.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="text-primary">
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Gejala</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($gejalas as $gejala)
                                    <tr>
                                        <td>{{ $gejala->kode }}</td>
                                        <td>{{ $gejala->nama }}</td>
                                        <td>{{ $gejala->deskripsi }}</td>
                                        <td class="td-actions">
                                            <a href="{{ route('gejala.show', $gejala->id) }}" class="btn btn-info btn-sm">
                                                <i class="material-icons">visibility</i>
                                            </a>
                                            <a href="{{ route('gejala.edit', $gejala->id) }}" class="btn btn-warning btn-sm">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <form action="{{ route('gejala.destroy', $gejala->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus gejala ini?')">
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

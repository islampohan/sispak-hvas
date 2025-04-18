@extends('layouts.teknisi')

@section('title', 'Detail Solusi')
@section('page-title', 'Detail Solusi')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">Informasi Solusi</h4>
                <p class="card-category">Detail informasi solusi untuk kerusakan HVAS</p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Kerusakan:</label>
                            <p>{{ $solusi->kerusakan->kode }} - {{ $solusi->kerusakan->nama }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Deskripsi Solusi:</label>
                            <p>{{ $solusi->deskripsi }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Langkah-langkah Perbaikan:</label>
                            <div class="p-3 bg-light rounded">
                                {!! nl2br(e($solusi->langkah_perbaikan)) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group text-right">
                    <a href="{{ route('solusi.index') }}" class="btn btn-default">Kembali</a>
                    <a href="{{ route('solusi.edit', $solusi->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('solusi.destroy', $solusi->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus solusi ini?')">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

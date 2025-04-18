@extends('layouts.user')

@section('title', 'Diagnosa')
@section('page-title', 'Diagnosa Kesalahan HVAS')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success">
                <h4 class="card-title">Form Diagnosa</h4>
                <p class="card-category">Pilih gejala kesalahan yang Anda temui pada HVAS</p>
            </div>
            <div class="card-body">
                <form action="{{ route('diagnosa.process') }}" method="POST">
                    @csrf

                    @if ($gejalas->isEmpty())
                        <div class="alert alert-warning">
                            Belum ada data gejala. Silakan hubungi teknisi untuk menambahkan data gejala.
                        </div>
                    @else
                        <div class="form-group">
                            <label class="font-weight-bold mb-3">Pilih Gejala:</label>

                            @foreach($gejalas as $gejala)
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" name="gejala[]" value="{{ $gejala->id }}">
                                        {{ $gejala->kode }} - {{ $gejala->nama }}
                                        <span class="form-check-sign">
                                            <span class="check"></span>
                                        </span>
                                    </label>
                                    @if($gejala->deskripsi)
                                        <p class="text-muted ml-4">{{ $gejala->deskripsi }}</p>
                                    @endif
                                </div>
                            @endforeach

                            @error('gejala')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="material-icons">search</i> Proses Diagnosa
                            </button>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

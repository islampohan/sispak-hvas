@extends('layouts.teknisi')

@section('title', 'Tambah Aturan')
@section('page-title', 'Tambah Aturan Baru')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">Form Tambah Aturan</h4>
                <p class="card-category">Tambahkan aturan baru untuk sistem pakar HVAS</p>
            </div>
            <div class="card-body">
                <form action="{{ route('aturan.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kode" class="bmd-label-floating">Kode Aturan</label>
                                <input type="text" class="form-control @error('kode') is-invalid @enderror" id="kode" name="kode" value="{{ old('kode') }}" required>
                                @error('kode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kerusakan_id">Kerusakan</label>
                                <select class="form-control @error('kerusakan_id') is-invalid @enderror" id="kerusakan_id" name="kerusakan_id" required>
                                    <option value="">-- Pilih Kerusakan --</option>
                                    @foreach($kerusakans as $kerusakan)
                                        <option value="{{ $kerusakan->id }}" {{ old('kerusakan_id', request('kerusakan_id')) == $kerusakan->id ? 'selected' : '' }}>
                                            {{ $kerusakan->kode }} - {{ $kerusakan->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kerusakan_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-right">
                        <a href="{{ route('aturan.index') }}" class="btn btn-default">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan & Tambah Gejala</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

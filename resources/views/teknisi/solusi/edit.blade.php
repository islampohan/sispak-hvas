@extends('layouts.teknisi')

@section('title', 'Edit Solusi')
@section('page-title', 'Edit Solusi')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">Form Edit Solusi</h4>
                <p class="card-category">Edit solusi untuk kerusakan HVAS</p>
            </div>
            <div class="card-body">
                <form action="{{ route('solusi.update', $solusi->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="kerusakan_id">Kerusakan</label>
                                <select class="form-control @error('kerusakan_id') is-invalid @enderror" id="kerusakan_id" name="kerusakan_id" required>
                                    <option value="">-- Pilih Kerusakan --</option>
                                    @foreach($kerusakans as $kerusakan)
                                        <option value="{{ $kerusakan->id }}" {{ old('kerusakan_id', $solusi->kerusakan_id) == $kerusakan->id ? 'selected' : '' }}>
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

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi Solusi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4" required>{{ old('deskripsi', $solusi->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="langkah_perbaikan">Langkah-langkah Perbaikan</label>
                                <textarea class="form-control @error('langkah_perbaikan') is-invalid @enderror" id="langkah_perbaikan" name="langkah_perbaikan" rows="6" required>{{ old('langkah_perbaikan', $solusi->langkah_perbaikan) }}</textarea>
                                <small class="form-text text-muted">
                                    Masukkan langkah-langkah perbaikan secara detail. Gunakan baris baru untuk memisahkan langkah.
                                </small>
                                @error('langkah_perbaikan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-right">
                        <a href="{{ route('solusi.index') }}" class="btn btn-default">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

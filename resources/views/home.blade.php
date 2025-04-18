{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('title', 'Home')
@section('page-title', 'Beranda')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">Selamat Datang di Sistem Pakar HVAS</h4>
                <p class="card-category">Sistem Pakar Identifikasi Kesalahan High Volume Air Sampler</p>
            </div>
            <div class="card-body">
                <p>Selamat datang, <strong>{{ auth()->user()->name }}</strong>!</p>

                <p>Anda telah berhasil login ke Sistem Pakar Identifikasi Kesalahan High Volume Air Sampler (HVAS).</p>

                <div class="alert alert-info">
                    <p>Anda akan dialihkan ke dashboard sesuai dengan peran Anda dalam beberapa detik. Jika tidak teralihkan secara otomatis, silakan klik tombol di bawah ini:</p>

                    <div class="text-center mt-3">
                        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">
                            <i class="material-icons">dashboard</i> Buka Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Redirect otomatis ke dashboard setelah 3 detik
    setTimeout(function() {
        window.location.href = "{{ route('dashboard') }}";
    }, 3000);
</script>
@endsection

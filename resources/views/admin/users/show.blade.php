@extends('layouts.admin')

@section('title', 'Detail Pengguna')
@section('page-title', 'Detail Pengguna')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">Informasi Pengguna</h4>
                <p class="card-category">Detail informasi pengguna sistem</p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama:</label>
                            <p>{{ $user->name }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email:</label>
                            <p>{{ $user->email }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Role:</label>
                            <p>
                                <span class="badge
                                    @if($user->role->name == 'admin') bg-danger
                                    @elseif($user->role->name == 'teknisi') bg-warning
                                    @else bg-info @endif">
                                    {{ ucfirst($user->role->name) }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Daftar:</label>
                            <p>{{ $user->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h4 class="mt-4">Aktivitas Pengguna:</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="text-primary">
                                    <tr>
                                        <th>Aktivitas</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Login Terakhir</td>
                                        <td>{{ $user->last_login_at ?? 'Belum pernah login' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Konsultasi</td>
                                        <td>{{ $user->konsultasis()->count() }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="form-group text-right">
                    <a href="{{ route('users.index') }}" class="btn btn-default">Kembali</a>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Edit</a>
                    @if($user->id != auth()->id())
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                Hapus
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

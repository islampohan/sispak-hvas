@extends('layouts.admin')

@section('title', 'Kelola Pengguna')
@section('page-title', 'Kelola Pengguna')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">Daftar Pengguna</h4>
                <p class="card-category">Kelola pengguna sistem pakar HVAS</p>
            </div>
            <div class="card-body">
                <div class="text-end mb-3">
                    <a href="{{ route('users.create') }}" class="btn btn-success">
                        <i class="material-icons">add</i> Tambah Pengguna
                    </a>
                </div>

                @if($users->isEmpty())
                    <div class="alert alert-info">
                        Belum ada data pengguna. Silakan tambahkan pengguna baru.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="text-primary">
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <span class="badge
                                                @if($user->role->name == 'admin') bg-danger
                                                @elseif($user->role->name == 'teknisi') bg-warning
                                                @else bg-info @endif">
                                                {{ ucfirst($user->role->name) }}
                                            </span>
                                        </td>
                                        <td>{{ $user->created_at->format('d M Y') }}</td>
                                        <td class="td-actions">
                                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm">
                                                <i class="material-icons">visibility</i>
                                            </a>
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            @if($user->id != auth()->id())
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                                        <i class="material-icons">delete</i>
                                                    </button>
                                                </form>
                                            @endif
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

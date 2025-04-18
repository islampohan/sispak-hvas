@extends('layouts.user')

@section('title', 'Predictive Maintenance')
@section('page-title', 'Predictive Maintenance HVAS')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-warning">
                <h4 class="card-title">Form Predictive Maintenance</h4>
                <p class="card-category">Hitung MTBF (Mean Time Between Failure) dan prediksi kerusakan berikutnya</p>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <strong>Tentang MTBF:</strong> Mean Time Between Failure adalah rata-rata waktu antara kegagalan/kerusakan komponen.
                    MTBF membantu memprediksi kapan kerusakan berikutnya akan terjadi, sehingga dapat dilakukan perawatan preventif.
                </div>

                <form action="{{ route('predictive-maintenance.calculate') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="komponen" class="bmd-label-floating">Komponen</label>
                        <select class="form-control" id="komponen" name="komponen" required>
                            @if($komponens->isEmpty())
                                <option value="">-- Belum ada data komponen --</option>
                            @else
                                <option value="">-- Pilih Komponen --</option>
                                @foreach($komponens as $komponen)
                                    <option value="{{ $komponen }}">{{ $komponen }}</option>
                                @endforeach
                            @endif
                            <option value="new">Komponen Baru (Input Manual)</option>
                        </select>
                    </div>

                    <div class="form-group" id="new-komponen-group" style="display: none;">
                        <label for="new_komponen" class="bmd-label-floating">Nama Komponen Baru</label>
                        <input type="text" class="form-control" id="new_komponen" name="new_komponen">
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Tanggal-tanggal Kerusakan</label>
                        <p class="text-muted">Masukkan minimal 2 tanggal kerusakan untuk menghitung MTBF</p>

                        <div id="tanggal-container">
                            <div class="row mb-3">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="tanggal_kerusakan[0]" class="bmd-label-floating">Tanggal Kerusakan 1</label>
                                        <input type="date" class="form-control" name="tanggal_kerusakan[]" required>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="tanggal_kerusakan[1]" class="bmd-label-floating">Tanggal Kerusakan 2</label>
                                        <input type="date" class="form-control" name="tanggal_kerusakan[]" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-primary btn-just-icon" id="tambah-tanggal">
                                        <i class="material-icons">add</i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-warning btn-lg">
                            <i class="material-icons">calculate</i> Hitung MTBF
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tampilkan/sembunyikan form input komponen baru
        document.getElementById('komponen').addEventListener('change', function() {
            const newKomponenGroup = document.getElementById('new-komponen-group');
            if (this.value === 'new') {
                newKomponenGroup.style.display = 'block';
                document.getElementById('new_komponen').setAttribute('required', true);
            } else {
                newKomponenGroup.style.display = 'none';
                document.getElementById('new_komponen').removeAttribute('required');
            }
        });

        // Tambah form input tanggal kerusakan
        let tanggalCounter = 2;
        document.getElementById('tambah-tanggal').addEventListener('click', function() {
            const container = document.getElementById('tanggal-container');
            const newRow = document.createElement('div');
            newRow.className = 'row mb-3';

            newRow.innerHTML = `
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="tanggal_kerusakan[${tanggalCounter}]" class="bmd-label-floating">Tanggal Kerusakan ${tanggalCounter + 1}</label>
                        <input type="date" class="form-control" name="tanggal_kerusakan[]" required>
                    </div>
                </div>
                <div class="col-md-5">
                    <!-- Kolom kosong untuk layout -->
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-just-icon hapus-tanggal">
                        <i class="material-icons">remove</i>
                    </button>
                </div>
            `;

            container.appendChild(newRow);
            tanggalCounter++;

            // Tambahkan event listener untuk tombol hapus
            newRow.querySelector('.hapus-tanggal').addEventListener('click', function() {
                container.removeChild(newRow);
            });
        });
    });
</script>
@endsection

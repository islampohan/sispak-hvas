@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('styles')
<style>
    .stat-card {
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .stat-card h2 {
        font-size: 2.5rem;
        margin-bottom: 5px;
    }
    .stat-card p {
        margin-bottom: 0;
        font-size: 1rem;
    }
    .bg-gradient-primary {
        background: linear-gradient(60deg, #ab47bc, #8e24aa);
    }
    .bg-gradient-success {
        background: linear-gradient(60deg, #66bb6a, #43a047);
    }
    .bg-gradient-info {
        background: linear-gradient(60deg, #26c6da, #00acc1);
    }
    .bg-gradient-danger {
        background: linear-gradient(60deg, #ef5350, #e53935);
    }
    .text-white {
        color: white;
    }
    .chart-container {
        height: 300px;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="card stat-card bg-gradient-primary text-white">
            <div class="card-body">
                <h2>{{ $totalGejala }}</h2>
                <p>Total Gejala</p>
            </div>
            <div class="card-footer">
                <i class="material-icons">healing</i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card stat-card bg-gradient-success text-white">
            <div class="card-body">
                <h2>{{ $totalKerusakan }}</h2>
                <p>Total Kerusakan</p>
            </div>
            <div class="card-footer">
                <i class="material-icons">build</i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card stat-card bg-gradient-info text-white">
            <div class="card-body">
                <h2>{{ $totalAturan }}</h2>
                <p>Total Aturan</p>
            </div>
            <div class="card-footer">
                <i class="material-icons">rule</i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card stat-card bg-gradient-danger text-white">
            <div class="card-body">
                <h2>{{ \App\Models\User::count() }}</h2>
                <p>Total Pengguna</p>
            </div>
            <div class="card-footer">
                <i class="material-icons">people</i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">Tren Kerusakan</h4>
                <p class="card-category">Grafik tren kerusakan dalam 6 bulan terakhir</p>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Data dari controller
        const trendData = @json($kerusakanTrend);

        // Persiapkan data untuk Chart.js
        const labels = trendData.map(item => item.bulan);
        const data = trendData.map(item => item.total);

        // Buat chart
        const ctx = document.getElementById('trendChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Kerusakan',
                    data: data,
                    backgroundColor: 'rgba(233, 30, 99, 0.2)',
                    borderColor: 'rgba(233, 30, 99, 1)',
                    borderWidth: 2,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    });
</script>
@endsection

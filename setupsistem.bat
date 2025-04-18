@echo off
echo Menyiapkan Middleware...
php artisan make:middleware AdminMiddleware
php artisan make:middleware TeknisiMiddleware
php artisan make:middleware UserMiddleware

echo Membuat model-model dan migration...
php artisan make:model Role -m
php artisan make:model Gejala -m
php artisan make:model Kerusakan -m
php artisan make:model Aturan -m
php artisan make:model Solusi -m
php artisan make:model Konsultasi -m
php artisan make:model DetailKonsultasi -m
php artisan make:model RiwayatKerusakan -m

echo Membuat controller-controller...
php artisan make:controller HomeController
php artisan make:controller DashboardController
php artisan make:controller Admin/UserController --resource
php artisan make:controller Teknisi/GejalaController --resource
php artisan make:controller Teknisi/KerusakanController --resource
php artisan make:controller Teknisi/AturanController --resource
php artisan make:controller Teknisi/SolusiController --resource
php artisan make:controller User/DiagnosaController
php artisan make:controller User/RiwayatController
php artisan make:controller User/PredictiveMaintenanceController

echo Membuat folder service...
mkdir app\Services

echo Selesai! Semua file telah dibuat.
pause

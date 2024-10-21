<?php

namespace App\Providers;

use App\Models\HistoryNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Set locale untuk aplikasi
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        
        // Memaksa HTTPS
        $this->app['request']->server->set('HTTPS', true);
        URL::forceScheme('https');

        // Ambil notifikasi (dapat diaktifkan jika model sudah ada dan migrasi sudah dijalankan)
        // $notifications = HistoryNotification::whereBetween('datetime', [now()->startOfDay(), now()->endOfDay()])
        //     ->where(function($query) {
        //         $query->where('status', '!=', true)->orWhereNull('status');
        //     })
        //     ->orderBy('id', 'desc')
        //     ->where('view', false)
        //     ->get();
        // view()->share('history_notifications', $notifications);

        // Ambil data dari tabel tblCameraSnapshot (SQL Server)
        // Pastikan driver dan koneksi SQL Server sudah benar
        try {
            $accessDoor = DB::connection('sqlsrv')->select('select * from tblCameraSnapshot');
            view()->share('access_door', $accessDoor);
        } catch (\Exception $e) {
            // Tangani kesalahan jika koneksi tidak berhasil
            \Log::error('Error fetching access door data: ' . $e->getMessage());
        }
    }
}

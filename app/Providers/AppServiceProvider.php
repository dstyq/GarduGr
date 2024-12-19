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
        // Pendaftaran layanan aplikasi jika diperlukan
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Menambahkan log untuk memantau apakah metode boot dipanggil
        \Log::info('AppServiceProvider booted.');

        // Mengatur lokalitas aplikasi
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');

        // Hapus atau komentari baris di bawah ini untuk tidak memaksa HTTPS
        // $this->app['request']->server->set('HTTPS', true);
        // URL::forceScheme('https');

        // Memastikan tabel yang diperlukan ada
        //$this->checkDatabaseTables();
    }

    /**
     * Cek apakah tabel yang diperlukan ada di database.
     *
     * @return void
     */
    protected function checkDatabaseTables()
    {
        // Daftar tabel yang diperlukan
        $tables = [
            'history_notifications',
            // Tambahkan tabel lain jika diperlukan
        ];

        foreach ($tables as $table) {
            if (!DB::table($table)->exists()) {
                \Log::error("Table '{$table}' does not exist.");
            } else {
                \Log::info("Table '{$table}' exists.");
            }
        }
    }
}

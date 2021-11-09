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

        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        
        $this->app['request']->server->set('HTTPS', true);
        URL::forceScheme('https');

        $notifications = HistoryNotification::whereBetween('datetime', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])->where(function($query) {
            $query->where('status', '!=', true)->orWhere('status', '=', null);
        })->orderBy('id', 'desc')->where('view', false)->get();
        view()->share('history_notifications', $notifications);

        $accessDoor = DB::connection('sqlsrv')->select('select * from tblCameraSnapshot');
        view()->share('access_door', $accessDoor);
    }
}

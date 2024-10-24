<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckPermissions extends Command
{
    protected $signature = 'permissions:check';
    protected $description = 'Check if the dashboard permission exists';

    public function handle()
    {
        $permission = Permission::where('name', 'dashboard')->first();
        if ($permission) {
            $this->info('Permission "dashboard" exists.');
        } else {
            $this->error('Permission "dashboard" does not exist.');
        }
    }
}

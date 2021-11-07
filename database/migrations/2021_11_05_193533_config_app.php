<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ConfigApp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_apps', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('access_door_count')->nullable();
            $table->timestamps();
        });

        DB::insert('insert into config_apps (id, access_door_count) values (?, ?)', [1, 0]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config_apps');
    }
}

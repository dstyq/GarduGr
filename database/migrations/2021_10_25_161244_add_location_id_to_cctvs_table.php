<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocationIdToCctvsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cctvs', function (Blueprint $table) {
            $table->bigInteger("location_id")->unsigned()->nullable();
            $table->foreign("location_id")->references("id")->on("locations");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cctvs', function (Blueprint $table) {
            $table->dropColumn('location_id');
        });
    }
}

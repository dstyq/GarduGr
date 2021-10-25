<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessDoorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('access_doors', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('link');
            $table->text('address')->nullable();
            $table->bigInteger("location_id")->unsigned()->nullable();
            $table->foreign("location_id")->references("id")->on("locations");
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('access_doors');
    }
}

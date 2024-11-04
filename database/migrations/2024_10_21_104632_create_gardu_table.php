<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGarduTable extends Migration
{
    public function up()
    {
        Schema::create('gardu', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('gardu_induk')->nullable(); 
            $table->timestamps(); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('gardu');
    }
}
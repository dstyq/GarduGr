<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImpedansiTrafoTable extends Migration
{
    public function up()
    {
        Schema::create('impedansi_trafo', function (Blueprint $table) {
            $table->id(); // Big Integer ID
            $table->foreignId('id_gardu')->nullable()->constrained('gardu')->onDelete('cascade');
            $table->decimal('mva_short_circuit', 10, 2)->nullable();
            //$table->decimal('mva_di_busbar', 10, 2)->nullable();
            $table->decimal('kapasitas', 10, 2)->nullable();
            $table->decimal('impedansi_trafo', 10, 2)->nullable();
            $table->decimal('volt_primer', 10, 2)->nullable();
            $table->decimal('volt_sekunder', 10, 2)->nullable();
            $table->string('belitan_delta')->nullable();
            $table->decimal('kapasitas_delta', 10, 2)->nullable();
            $table->decimal('ratio_c_t_20kv_1', 10, 2)->nullable();
            $table->decimal('ratio_c_t_20kv_2', 10, 2)->nullable();
            $table->decimal('pentahanan_netral', 10, 2)->nullable();
            $table->decimal('xt_1', 10, 2)->nullable();
            $table->decimal('xt_0', 10, 2)->nullable();
            $table->decimal('i_nominal_20kv', 10, 2)->nullable();
            $table->decimal('impedansi_sumber', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('impedansi_trafo');
    }
}

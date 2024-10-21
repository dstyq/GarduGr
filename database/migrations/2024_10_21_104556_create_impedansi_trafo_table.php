<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImpedansiTrafoTable extends Migration
{
    public function up()
    {
        Schema::create('impedansi_trafo', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('id_gardu')->nullable()->constrained('gardu')->onDelete('cascade');
            $table->decimal('mva_short_circuit')->nullable();
            $table->decimal('mva_di_busbar')->nullable();
            $table->decimal('kapasitas')->nullable();
            $table->decimal('impedansi_trafo')->nullable();
            $table->decimal('volt_primer')->nullable();
            $table->decimal('volt_sekunder')->nullable();
            $table->string('belitan_delta')->nullable();
            $table->decimal('kapasitas_delta')->nullable();
            $table->decimal('ratio_c_t_20kv_1')->nullable();
            $table->decimal('ratio_c_t_20kv_2')->nullable();
            $table->decimal('pentahanan_netral')->nullable();
            $table->decimal('xt_1')->nullable();
            $table->decimal('i_nominal_20kv')->nullable();
            $table->decimal('impedansi_sumber')->nullable();
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('impedansi_trafo');
    }
}
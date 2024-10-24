<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImpedansiTrafo extends Model
{
    protected $table = 'impedansi_trafo';

    protected $fillable = [
        'id_gardu',
        'mva_short_circuit',
        'mva_di_busbar',
        'kapasitas',
        'impedansi_trafo',
        'volt_primer',
        'volt_sekunder',
        'belitan_delta',
        'kapasitas_delta',
        'ratio_c_t_20kv_1',
        'ratio_c_t_20kv_2',
        'pentahanan_netral',
        'xt_1',
        'i_nominal_20kv',
        'impedansi_sumber',
    ];

    // Relasi ke model Gardu
    public function gardu()
    {
        return $this->belongsTo(Gardu::class, 'id_gardu');
    }
}

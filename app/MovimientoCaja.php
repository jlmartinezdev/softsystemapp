<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovimientoCaja extends Model
{
    protected $table= "movimiento_caja";
    protected $primaryKey = 'mov_cod';
    public $timestamps = false;
    protected $fillable = [
        'mov_cod', 'nro_operacion', 'mov_fecha', 'mov_concepto', 'mov_tipo', 'mov_monto', 'nro_fact_ventas', 'suc_cod'
    ];
}

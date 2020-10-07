<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table= 'stock';
    protected $primaryKey = 'id_stock';
    public $timestamps = false;
    protected $fillable = [
        'ARTICULOS_cod','suc_cod','cantidad','stock_fech_venc','lote_nro'
    ];
}

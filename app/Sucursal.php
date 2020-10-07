<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    protected $table= 'sucursales';
    protected $primaryKey = 'suc_cod';
    public $timestamps = false;
    protected $fillable = [
        'suc_desc','suc_direc','suc_cel'
    ];
}

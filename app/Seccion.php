<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{
    //
    protected $table= "presentacion";
    protected $primaryKey = 'present_cod';
    public $timestamps = false;
    protected $fillable = [
        'present_descripcion', 'iva'
    ];
}

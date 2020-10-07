<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    protected $table= "unidad";
    protected $primaryKey = 'uni_codigo';
    public $timestamps = false;
    protected $fillable = [
        'uni_nombre','uni_abreviatura'
    ];
}

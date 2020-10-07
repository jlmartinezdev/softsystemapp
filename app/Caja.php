<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $table= "caja";
    protected $primaryKey = 'caja_cod';
    public $timestamps = false;
    protected $fillable = [
        'caja_cod', 'caja_descrip'
    ];
}

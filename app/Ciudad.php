<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    protected $primaryKey = 'CIUDAD_cod';
    protected $table= 'ciudad';
    public $timestamps = false;
    protected $fillable = [
		'CIUDAD_cod', 'depart_codigo', 'ciudad_nombre'
	];
}

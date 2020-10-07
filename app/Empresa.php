<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table= 'empresa';
    protected $primaryKey = 'emp_codigo';
    public $timestamps = false;
}

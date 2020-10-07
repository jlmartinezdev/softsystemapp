<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Venta extends Model
{
    protected $primaryKey= "nro_fact_ventas";
    public $timestamps = false;
    public function scopeFiltrofecha($query,$desde,$hasta){
    	
    	if(!empty($desde) && !empty($hasta)){
			return $query->whereBetween(DB::raw("date(ventas.venta_fecha)"),[$desde,$hasta]);
		}else{
			return $query->paginate("100");
		}
    }
    public function scopeFiltrochart($query,$mes,$anho,$byYear){
    	if($byYear){
    		return $query->where(DB::raw("YEAR(ventas.venta_fecha)"),"=",$anho);
    	}else{
    		return $query->where(DB::raw("YEAR(ventas.venta_fecha)"),"=",$anho)
    		->where(DB::raw("MONTH(ventas.venta_fecha)"),"=",$mes);
    	}
    }
    public function scopeFiltrosuc($query,$suc){
        if($suc!='0'){
            return $query->where('s.suc_cod','=',$suc);
        }
    }
}

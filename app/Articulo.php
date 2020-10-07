<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    
    protected $primaryKey = 'articulos_cod';
    public $timestamps = false;
    protected $fillable = ['producto_nombre'];
    /*protected $fillable = [
        'uni_codigo', 'producto_c_barra','present_cod','producto_nombre','producto_costo_compra','foto','producto_fecHab','producto_vencimiento','pre_venta1','pre_venta2','pre_venta3','pre_venta4','producto_ubicacion','producto_peso','producto_factor','pre_margen1','pre_margen2','pre_margen3','pre_margen4','producto_indicaciones','producto_dosis','producto_formula','producto_dimagen'
    ]*/
    public function scopeDescripcion($query, $descripcion){
    	if($descripcion)
    		return $query->where('articulos.producto_nombre','LIKE',"%$descripcion%");
    }
    public function scopeSeccion($query,$seccion){
    	if($seccion)
    		return $query->where('presentacion.present_cod','=',$seccion);
    }
    public function scopeBysucursal($query, $id){
        if($id)
            return $query->where('stock.suc_cod','=',$id);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CtaCobrar extends Model
{
    protected $primaryKey = 'nro_cuotas';
    protected $table= 'ctas_cobrar';
    public $timestamps = false;
    protected $fillable = [
		'monto_cuota','monto_cobrado','monto_saldo','fecha_venc','estado','interes'
	];
    public function scopeCliente($query,$cliente,$buscarpor,$ci){
        if(!empty($cliente) && $buscarpor=='cliente'){
            if(strtoupper($cliente)=='TODOS'){
                return;
            }
            if($ci=="true"){
                return $query->where('c.cliente_ci','=',$cliente);
            }else {
                return $query->where('c.cliente_nombre','LIKE',"%$cliente%");
            }
        }
            
            
    }
    public function scopeDireccion($query,$direccion,$buscarpor){
        if($direccion && $buscarpor=='direccion'){
            if(strtoupper($direccion)=='TODOS'){
                return;
            }
            return $query->where('c.cliente_direccion','LIKE',"%$direccion%");
        }
    }
    public function scopeOrdenar($query,$tipo,$ascdesc, $txtbuscar){
        if(strtoupper($txtbuscar)=='TODOS'){
            return $query->orderBy('c.cliente_direccion',$ascdesc);        
        }
        $sql='';
        switch ($tipo) {
            case '1':
                $sql= $query->orderBy('ctas_cobrar.nro_fact_ventas',$ascdesc);
                break;
            case '2':
                $sql= $query->orderBy('c.cliente_ruc',$ascdesc);
                break;
            case '3':
                $sql= $query->orderBy('c.cliente_nombre',$ascdesc);
                break;
            case '4':
                $sql= $query->orderBy('ventas.venta_fecha',$ascdesc);
                break;
            case '5':
                $sql= $query->orderBy('cuotas',$ascdesc);
                break;
            case '6':
                $sql= $query->orderBy('total',$ascdesc);
                break;
            default:
                $sql=$query->orderBy('ctas_cobrar.nro_fact_ventas',$ascdesc);
                break;
        }
        return $sql;
    }
}

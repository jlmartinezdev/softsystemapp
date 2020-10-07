<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{

    protected $primaryKey = 'Clientes_cod';
    public $timestamps = false;
    protected $fillable = [
		'CLIENTES_cod', 'CIUDAD_cod', 'cliente_ci', 'cliente_nombre', 'cliente_ruc', 'cliente_direccion', 'cliente_telef', 'cliente_cel', 'cliente_correo'
	];
	public function scopeNombre($query, $nombre){
    	if($nombre)
    		return $query->whereRaw('upper(clientes.cliente_nombre) like ?',["%{$nombre}%"]);
    }
    public function scopeDocumento($query, $documento){
    	if($documento)
    		return $query->where('clientes.cliente_ci','=',$documento);
    }
}

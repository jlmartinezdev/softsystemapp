<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Apertura;
use App\MovimientoCaja;
use DB;
class MovimientoCajaController extends Controller
{
    public function index(){
    	return view('movimiento');
    }
    public function getAll($nro_operacion){
    	return MovimientoCaja::select(DB::raw('DATE_FORMAT(mov_fecha,"%d/%m/%Y %H:%i") AS mov_fecha'),'mov_concepto','mov_tipo','mov_monto')
    	->where('nro_operacion','=',$nro_operacion)->get();
    }
    public function store(Request $request){
    	$movimiento= new MovimientoCaja();
    	$movimiento->nro_operacion= $request->data['nro_operacion'];
    	$movimiento->mov_fecha= date('Y-m-d H:i');
    	$movimiento->mov_concepto= $request->data['descripcion'];
    	$movimiento->mov_tipo= $request->data['tipo'];
    	$movimiento->mov_monto= $request->data['monto'];
    	$movimiento->nro_fact_ventas= '-';
    	$movimiento->suc_cod= $request->data['idSucursal'];
    	$movimiento->save();
    	return $this->getAll($request->data['nro_operacion']);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Apertura;
use App\Sucursal;
use App\Caja;
use App\MovimientoCaja;
use DB;

class AperturaController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
    	$sucursales= Sucursal::all();
    	$cajas= Caja::all();
    	$aperturas= Apertura::join('sucursales','apert_cierres_caja.suc_cod','=','sucursales.suc_cod')
        ->join('caja','apert_cierres_caja.caja_cod','=','caja.caja_cod')
        ->orderBy('nro_operacion','DESC')
        ->limit(10)
        ->get();
    	return view('apertura',compact('sucursales','cajas','aperturas'));
    }
    public function indexCierre($operacion){
    	$apertura= Apertura::join('sucursales','apert_cierres_caja.suc_cod','=','sucursales.suc_cod')->join('caja','apert_cierres_caja.caja_cod','=','caja.caja_cod')->orderBy('nro_operacion','DESC')
    		->where("apert_cierres_caja.nro_operacion","=",$operacion)->get();
    	//return $apertura;
    		if(count($apertura)>0){
    			return view('cierre',compact('apertura'));		
    		}else{
    			return redirect()->route('apertura');
    		}
    	
    }
    public function store(Request $request){  
        if(!empty($this->getStatu($request->sucursal)))
        {
            return redirect()->back();
        } 
            
        
    	$date= date('Y-m-d');
    	$hora= date('H:i:s');
    	$apertura= new Apertura();
    	$apertura->cod_usuarios= $request->usuario ;
    	$apertura->caja_cod= $request->caja;
    	$apertura->apert_fecha= $date;
    	$apertura->apert_hora= $hora;
    	$apertura->apert_monto= $request->monto;
    	$apertura->apert_estado= 1;
    	$apertura->suc_cod= $request->sucursal;
    	$apertura->save();
    	$this->storeMovimiento($request->sucursal,$apertura->nro_operacion,$request->monto);
    	return redirect()->back();
    }
    private function storeMovimiento($idSucursal,$ope,$monto ){
        $movimiento= new MovimientoCaja();
        $movimiento->nro_operacion= $ope;
        $movimiento->mov_fecha= date('Y-m-d H:i');
        $movimiento->mov_concepto= 'Monto Inicial';
        $movimiento->mov_tipo= 'Entrada';
        $movimiento->mov_monto= $monto;
        $movimiento->nro_fact_ventas= '-';
        $movimiento->suc_cod= $idSucursal;
        $movimiento->save();
    }
    public function update(Request $request){
    	$date= date('Y-m-d');
    	$hora= date('H:i:s');
    	Apertura::find($request->nro_operacion)->update(['cierre_fecha'=> $date, 'cierre_hora'=> $hora, 'cierre_monto'=>$request->monto, 'apert_estado'=> '0']);
    	return redirect()->route('apertura');

    }
    public function getStatu($id){
        $date= date('Y-m-d');
        $archivo= base_path()."/configuracion.ini";
        $contenido= parse_ini_file($archivo);
        switch ($contenido['validez_apertura']) {
            case '1':
                return Apertura::where('apert_cierres_caja.suc_cod','=',$id)
                ->where('apert_cierres_caja.apert_fecha','=',$date)
                ->where('apert_estado','=','1')
                ->first();
                break;
            case '2':
                return Apertura::where('apert_cierres_caja.suc_cod','=',$id)
                ->where(DB::raw('TIMESTAMPDIFF(HOUR,CONCAT(apert_cierres_caja.apert_fecha," ",apert_cierres_caja.apert_hora),NOW())'),'<','24')
                ->where('apert_estado','=','1')
                ->get()
                ->last();
                break;
            
            default:
                return Apertura::where('apert_cierres_caja.suc_cod','=',$id)
                ->where('apert_estado','=','1')
                ->get()
                ->last();
                break;
        }
    }
    public function comando(){
        $exitCode = Artisan::call('config:clear');
        $exitCode = Artisan::call('cache:clear');
        $exitCode = Artisan::call('config:cache');
        return 'DONE'; //Return anything
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CtaCobrar;

use DB;
use PDF;
class CtaCobrarController extends Controller
{
    public function indexInf(){
        return view('informes.ctacobrar');
    }
    public function infToPdf(Request $request){
        if(!empty($request->buscar)){
            $ci= is_numeric($request->buscar);
            $ctas= $this->getCtas($request,$ci);
            $articulos= $this->getArticuloFromCta($request,$ci);
            $pdf= PDF::loadView('pdf.ctacobrar',compact('ctas','articulos'));
            return $pdf->stream();
            return view('pdf.ctacobrar',compact('ctas','articulos'));
        }else{
           return back(); 
        }
        
       // return $request;
    }

    public function getCtaCobrar(Request $request){
     return [
        'ctas'=>$this->getCtas($request,$request->ci),
        'articulos' => $this->getArticuloFromCta($request,$request->ci)
    ];
        
    }
    public function getCtasPagadas(Request $request){

    }
    private function getCtas($request, $ci){
        return $ctas= CtaCobrar::join('ventas','ctas_cobrar.nro_fact_ventas','ventas.nro_fact_ventas')
        ->join('clientes as c','ventas.clientes_cod','c.CLIENTES_cod')
        ->select('ctas_cobrar.nro_fact_ventas',DB::raw('COUNT(ctas_cobrar.nro_cuotas) as "cuotas"'),DB::raw('SUM(ctas_cobrar.monto_cobrado) as "cobrado"'),DB::raw('SUM(ctas_cobrar.monto_cuota) as "total"'),DB::raw('SUM(ctas_cobrar.monto_saldo) as "saldo"'),DB::raw('COUNT(IF(ctas_cobrar.estado=1,1,NULL)) AS "nopagada"'), DB::raw('COUNT(IF(ctas_cobrar.estado=0,1,NULL)) AS "pagada"'),DB::raw('DATE_FORMAT(ventas.venta_fecha,"%d/%m/%Y") as venta_fecha'),DB::raw('DATE_FORMAT(ventas.venta_fecha,"%Y-%m-%d") as fecha_v'),'ventas.venta_descuento','c.cliente_ruc','c.cliente_nombre','c.cliente_direccion', 'c.cliente_cel')
        ->cliente($request->buscar,$request->buscarpor,$ci)
        ->direccion($request->buscar,$request->buscarpor)
        ->groupBy('ctas_cobrar.nro_fact_ventas')
        ->having('saldo','>',0)
        ->ordenar($request->ordenarpor,$request->ord,$request->buscar)
        ->get();

       
    }
    private function getArticuloFromCta($filtro,$ci){
        return CtaCobrar::join('ventas as v','ctas_cobrar.nro_fact_ventas','v.nro_fact_ventas')
        ->join('detalle_venta as dv','v.nro_fact_ventas','dv.nro_fact_ventas')
        ->join('articulos as a','dv.articulos_cod','a.articulos_cod')
        ->join('clientes as c','v.clientes_cod','c.clientes_cod')
        ->select('ctas_cobrar.nro_fact_ventas','a.producto_c_barra','a.producto_nombre','dv.venta_cantidad','dv.venta_precio')
        ->cliente($filtro->buscar,$filtro->buscarpor,$ci)
        ->direccion($filtro->buscar,$filtro->buscarpor)
        ->groupBy('a.articulos_cod','v.nro_fact_ventas')
        ->orderBy('v.nro_fact_ventas','ASC')
        ->get();
    }
}

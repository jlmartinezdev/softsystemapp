<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CtaCobrar;

use DB;
class CtaCobrarController extends Controller
{
    public function indexInf(){
        return view('informes.ctacobrar');
    }

    public function getCtaCobrar(Request $request){
    
        $ctas= CtaCobrar::join('ventas','ctas_cobrar.nro_fact_ventas','ventas.nro_fact_ventas')
        ->join('clientes as c','ventas.clientes_cod','c.CLIENTES_cod')
        ->select('ctas_cobrar.nro_fact_ventas',DB::raw('COUNT(ctas_cobrar.nro_cuotas) as "cuotas"'),DB::raw('SUM(ctas_cobrar.monto_cobrado) as "cobrado"'),DB::raw('SUM(ctas_cobrar.monto_cuota) as "total"'),DB::raw('SUM(ctas_cobrar.monto_saldo) as "saldo"'),DB::raw('COUNT(IF(ctas_cobrar.estado=1,1,NULL)) AS "nopagada"'), DB::raw('COUNT(IF(ctas_cobrar.estado=0,1,NULL)) AS "pagada"'),DB::raw('DATE_FORMAT(ventas.venta_fecha,"%d/%m/%Y") as venta_fecha'),'ventas.venta_descuento','c.cliente_ruc','c.cliente_nombre','c.cliente_direccion', 'c.cliente_cel')
        ->cliente($request->buscar,$request->buscarpor,$request->ci)
        ->direccion($request->buscar,$request->buscarpor)
        ->groupBy('ctas_cobrar.nro_fact_ventas')
        ->having('saldo','>',0)
        ->ordenar($request->ordenarpor,$request->ord)
        ->get();
        return [
            'ctas'=>$ctas,
            'articulos' => $this->getArticuloFromCta($request)
        ];
    }
    private function getArticuloFromCta($filtro){
        return CtaCobrar::join('ventas as v','ctas_cobrar.nro_fact_ventas','v.nro_fact_ventas')
        ->join('detalle_venta as dv','v.nro_fact_ventas','dv.nro_fact_ventas')
        ->join('articulos as a','dv.articulos_cod','a.articulos_cod')
        ->join('clientes as c','v.clientes_cod','c.clientes_cod')
        ->select('ctas_cobrar.nro_fact_ventas','a.producto_c_barra','a.producto_nombre','dv.venta_cantidad','dv.venta_precio')
        ->cliente($filtro->buscar,$filtro->buscarpor,$filtro->ci)
        ->direccion($filtro->buscar,$filtro->buscarpor)
        ->groupBy('a.articulos_cod','v.nro_fact_ventas')
        ->orderBy('v.nro_fact_ventas','ASC')
        ->get();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Venta;
use App\Apertura;
use App\Sucursal;
use App\MovimientoCaja;
use App\Empresa;
use DB;
use Auth;
use PDF;
class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
       // return view('venta.generar');
        $apertura=Apertura::join('sucursales','apert_cierres_caja.suc_cod','=','sucursales.suc_cod')->join('caja','apert_cierres_caja.caja_cod','=','caja.caja_cod')
        ->where('apert_cierres_caja.apert_fecha','=',date('Y-m-d'))->get();
        return view('venta',compact('apertura'));
    }
    public function indexInf(){
        $sucursales= Sucursal::all();
        return view('informes.venta',compact('sucursales'));
    }
    public function getVentaByFecha(Request $request){
        return Venta::select('ventas.nro_fact_ventas','ventas.documento','ventas.venta_total',DB::raw('DATE_FORMAT(ventas.venta_fecha,"%d/%m/%Y %H:%i") AS fecha'),'c.cliente_nombre', 'c.cliente_direccion', 'c.cliente_ruc','s.suc_desc','ventas.tipo_factura')
        ->join('clientes as c','ventas.clientes_cod','=','c.clientes_cod')
        ->join('sucursales as s','ventas.suc_cod','=','s.suc_cod')
        ->filtrofecha($request->alld,$request->allh)
        ->filtrosuc($request->alls)
        ->orderBy('ventas.nro_fact_ventas','desc')
        ->get();

    }
    public function getVentaArticulo(Request $request){
        $suc= $request->arts!='0' ? 'v.suc_cod='.$request->arts.' AND ' :'';
         return DB::select("SELECT SUM(dv.venta_cantidad) AS vendida, dv.ARTICULOS_cod, a.producto_c_barra, a.producto_nombre, s.cantidad, p.present_descripcion FROM detalle_venta dv INNER JOIN ventas v ON dv.nro_fact_ventas=v.nro_fact_ventas INNER JOIN articulos a ON dv.ARTICULOS_cod=a.ARTICULOS_cod INNER JOIN stock s ON a.ARTICULOS_cod= s.ARTICULOS_cod INNER JOIN presentacion p ON a.present_cod=p.present_cod WHERE ".$suc." DATE(v.venta_fecha) BETWEEN '".$request->artd."' AND '".$request->arth."' GROUP BY dv.ARTICULOS_cod ORDER BY vendida DESC");
    }
    public function getDetalle($nro_venta){
        return DB::select('SELECT dv.*,a.producto_nombre,a.producto_c_barra,p.iva FROM detalle_venta dv INNER JOIN articulos a ON dv.ARTICULOS_cod=a.ARTICULOS_cod inner join presentacion p on a.present_cod=p.present_cod where dv.nro_fact_ventas=?',[$nro_venta]);
    }
    public function getVentaChart(Request $request){
        
       return Venta::select(DB::raw("SUM(ventas.venta_total) AS total"),DB::raw("DATE_FORMAT(ventas.venta_fecha,'%Y-%m-%d') AS fecha"))
        ->filtrochart($request->chart['mes'],$request->chart['anho'],$request->chart['byYear'])
        ->groupBy(DB::raw("DATE(ventas.venta_fecha)"))
        ->get();

    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $venta = new Venta();
        $venta->clientes_cod= $request->ventaCabecera['clienteId'];
        $venta->cod_usuarios= Auth::user()->cod_usuarios;
        $venta->suc_cod= $request->ventaCabecera['idSucursal'];
        $venta->venta_total= $request->ventaCabecera['total'];
        $venta->venta_fecha = date('Y-m-d H:i');
        $venta->tipo_factura = $request->ventaCabecera['condicionventa'];
        $venta->cant_cuotas =0;
        $venta->intervalo_venc='2030-01-01'; 
        $venta->venta_estado='2'; 
        $venta->venta_descuento='0'; 
        $venta->forma_cobro= $request->ventaCabecera['formacobro']; 
        $venta->documento= $request->ventaCabecera['documento']; 
        $venta->save();
        if($request->ventaCabecera['condicionventa']=='1'){
            $this->storeMovimiento($venta,$request->ventaCabecera['idSucursal'],$request->ventaCabecera['nro_operacion']);
        }
        
        foreach ($request->detalle as $detalle) {
           // $lote = empty($detalle['aux_lote']) ? " AND lote_nro is null": " AND lote_nro='".trim($detalle['aux_lote'])."'");
            DB::insert('INSERT INTO detalle_venta (ARTICULOS_cod, nro_fact_ventas, venta_precio, venta_cantidad) VALUES (?, ?, ?, ?)',[$detalle['codigo'],$venta->nro_fact_ventas,$detalle['precio'],$detalle['cantidad']]);
           DB::update('update stock set cantidad = (cantidad - ?) where id_stock=?',[$detalle['cantidad'],$detalle['idstock']]);
        }
        return $venta->nro_fact_ventas;
        
    }

   
  

   private function storeMovimiento(Venta $venta,$idSucursal,$ope ){
        $movimiento= new MovimientoCaja();
        $movimiento->nro_operacion= $ope;
        $movimiento->mov_fecha= date('Y-m-d H:i');
        $movimiento->mov_concepto= 'Venta Nº: '.$venta->nro_fact_ventas;
        $movimiento->mov_tipo= 'Entrada';
        $movimiento->mov_monto= $venta->venta_total;
        $movimiento->nro_fact_ventas= $venta->nro_fact_ventas;
        $movimiento->suc_cod= $idSucursal;
        $movimiento->save();
        
    }
    public function pdfboleta($id){
       
        $venta =  Venta::join('clientes','clientes.CLIENTES_cod','=','ventas.CLIENTES_cod')->where('ventas.nro_fact_ventas',$id)->first();
        $detalle= $this->getDetalle($id);
        $empresa= Empresa::first();
        //$pdf= PDF::loadView('pdf.venta',compact('venta','detalle','empresa'));
        // return $pdf->stream();
        return view('pdf.venta',compact('venta','detalle','empresa'));
    }
   
}

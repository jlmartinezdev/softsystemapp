@extends('layouts.app')
@section('title','Informe de Cuenta a Cobrar')
@section('style')
<style type="text/css" media="all">
   table td {
       font-size: 10pt;
       padding: 0px;
       /**/
   }
   .mystriped{
    background-color: #f2f2f2 !important; 
   }
   .trsimple{
    line-height: 0.8em;
   }
   body{
    background-color: white;
    -webkit-print-color-adjust: exact;
   }
   @media print{
    .mystriped{
    background-color: #f2f2f2 !important; 
   }
   #frmparametro{
    display: none;
   }
   }

</style>
@endsection
@section('main')
<div id="app">
    <div class="container">
        <div class="card" id="frmparametro">
            <div class="card-header bg-dark font-weight-bold text-white">Informes de cuentas a cobrar</div>
            <div class="card-body">
            <form action="{{route('infctacobrar@pdf')}}" method="post">
            @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" v-model="txtbuscar" name="buscar" @keydown.enter="$event.preventDefault();" @keyup.enter="buscar(false)" class="form-control" placeholder="Buscar...."/>
                            <div class="input-group-append">
                              <button class="btn btn-secondary" @click="$event.preventDefault();buscar(false)" type="button" >
                                <template v-if="requestSend">
                                    <span class="spinner-border spinner-border-sm" role="status"></span><span class="sr-only">Buscando...</span> Cargando...
                                </template>
                                <template v-else>
                                   <span class="fa fa-search"></span> Buscar
                                </template>
                                </button>
                            </div>
                        </div>           
                    </div>
                    <div class="col-md-5">
                        <div class="d-flex">
                            <div class="border-left pl-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="cliente" v-model="filtro.busquedapor" name="buscarpor" id="defaultCheck1">
                                    <label class="form-check-label" for="defaultCheck1">
                                    <strong>Buscar por Cliente</strong>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="direccion" v-model="filtro.busquedapor" name="busquedapor" id="defaultCheck2">
                                    <label class="form-check-label" for="defaultCheck2">
                                    <strong>Buscar por Direccion</strong>
                                    </label>
                                </div>
                            </div>
                            <div class="ml-2 border-left pl-2">
                                <select class="form-control form-control-sm" name="ordenarpor" @change="buscar(false)" v-model="filtro.ordenarpor">
                                    <option value="0">Ordenar Por</option>
                                    <option value="1">Nro. Venta</option>
                                    <option value="2">Documento</option>
                                    <option value="3">Cliente</option>
                                    <option value="4">Fecha</option>
                                    <option value="5">Cant. cuota</option>
                                    <option value="6">Total</option>
                                    <option value="7">Saldo</option>
                                    

                                </select>
                            </div>
                            <div class="ml-2 border-left pl-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="ASC" @click="buscar(false)" name="ord" v-model="filtro.orden" id="defaultCheck3">
                                    <label class="form-check-label" for="defaultCheck3">
                                    ASC
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="DESC" @click="buscar(false)" v-model="filtro.orden" name="ord" id="defaultCheck4">
                                    <label class="form-check-label" for="defaultCheck4">
                                    DESC
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
                    <div class="col-md-3">
                        <!-- button class="btn btn-primary btn-block" type="submit" ><span class="fa fa-print"></span> Exportar a PDF</button -->
                    </div>
                </div>
                </form>
            </div>    
        </div>
        <br>
        <table class="table table-sm table-borderless ">
            <tr>
                <th>Resultado de busqueda - Cuentas a Cobrar</th>
            </tr>
            <template v-for="(c,index) in ctas">
                <tr>
                    <!-- :class="{'mystriped': index % 2==0}" -->
                    <td>
                        <table class="table table-sm border border-top">
                           
                            <tr class="mb-4 font-weight-bold text-primary">
                                <td><span class="fa fa-address-card text-secondary"></span> @{{ c.cliente_ruc }}</td>
                                <td colspan="2"><span class="fa fa-user text-secondary"></span> @{{ c.cliente_nombre }}</td>
                                <td colspan="2"><span class="fa fa-map-marker-alt text-secondary"></span> @{{ c.cliente_direccion}}</td>
                                <td colspan="2"><span class="fa fa-phone-alt text-secondary"></span> @{{ c.cliente_cel}}</td>
                            </tr>
                            
                            <tr>
                                <th>Nro. Venta</th>
                                <th>Fecha Venta</th>
                                <th>Importe</th>
                                <th>Cobrado/ Cuota</th>
                                <th>Entrega + Cuota Cobrado</th>
                                <th>Saldo</th>
                                <th>Atraso</th>
                            </tr>
                            <tr class="trsimple">
                                <td>@{{ c.nro_fact_ventas }}</td>
                                <td>@{{ c.venta_fecha }}</td>
                                <td>@{{ format(c.total)}}</td>
                                <td>@{{ (c.pagada-1) +" de "+ (c.cuotas-1)  }}</td>
                                <td>@{{ format(c.cobrado) }}</td>
                                <td class="text-danger font-weight-bold">@{{ format(c.saldo)}}</td>
                                <td>@{{ diferenciaFecha(c.fecha_v,c.pagada-1) + " dias" }}</td>
                            </tr>
                            <tr>
                                <td colspan="7" class="border-bottom"><strong>Detalle de Venta</strong>  - Descuento: @{{format(c.venta_descuento)}}  </td>
                            </tr>
                            <tr>
                                <td><strong>Codigo</strong></td>
                                <td colspan="2"><strong>Descripcion</strong></td>
                                <td><strong>Cantidad</strong></td>
                                <td class="text-right"><strong>Precio</strong></td>
                                <td class="text-right" colspan="2"><strong>Importe</strong></td>
                            </tr>
                            <template v-for="dv in detalleVenta(c.nro_fact_ventas)">
                                <tr>
                                    <td>@{{dv.producto_c_barra}}</td>
                                    <td colspan="2">@{{dv.producto_nombre}}</td>
                                    <td>@{{parseInt(dv.venta_cantidad)}}</td>
                                    <td class="text-right">@{{format(dv.venta_precio)}}</td>
                                    <td class="text-right" colspan="2">@{{format(dv.venta_cantidad * dv.venta_precio) }}</td>
                                </tr>
                            </template>
                            
                        </table>  
                    </td>
                </tr>    
            </template>
        </table>
    </div>
    <div class="modal fade" id="frmcompania">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">      
                <h4 class="modal-title">Compañias</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Cerrar</span>
                    </button>
              
                </div>
                <div class="modal-body">
                    <p>One fine body&hellip;</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
@endsection
@section('script')
<script>
    var app= new Vue({
        el :'#app',
        data: {
            requestSend: false,
            filtro : {orden:'ASC',busquedapor : 'cliente',ordenarpor:'0',ci: false},
            txtbuscar: '',
            ctas:[],
            articulos:[],
            error:''
        },
        methods:{
            buscar : function(p1){
                if(this.txtbuscar.length<1)
                    return

                this.requestSend= true;
                if(this.filtro.busquedapor=='cliente'){
                    var t=parseFloat(this.txtbuscar);
		  		    if(isNaN(t)){
                        this.filtro.ci= false;
                    }else{
                        this.filtro.ci= true;
                    }
                }
                axios.get('ctas_cobrar/buscar',{
			        params:{buscar:this.txtbuscar,ci:this.filtro.ci,buscarpor:this.filtro.busquedapor,ordenarpor:this.filtro.ordenarpor,ord:this.filtro.orden}
                })
                .then(response=>{
                    this.requestSend= false;
                    if(response.data=='NO'){
                    Swal.fire('No se encontrado resultado!','Para:  '+this.txtbuscar, 'info' );
                    }else{
                    this.ctas= response.data.ctas;
                    this.articulos = response.data.articulos;
                   // this.paginacion= response.data.paginacion;
                    //this.paginacion.pagina_actual=1;
                    }
                    this.requestSend= false;
                        //this.error=response.data;
                })
                .catch(e=>{
                    this.requestSend= false;
                    this.error= e.message;
                });
            },
            format: function(numero){
            	return new Intl.NumberFormat("de-DE").format(numero);
            },
            detalleVenta: function(nroventa){
                return this.articulos.filter(function(venta){
                    return venta.nro_fact_ventas==nroventa
                })
            },
            showComunidades: function(){
                $('#frmcompania').modal('show');
            },
            diferenciaFecha: function(fecha_vent, pagada){
                //2016-07-12
                var fechaInicio = new Date(fecha_vent).getTime();
                var fechaFin    = new Date().getTime();
                var diff = fechaFin - fechaInicio;
                var dia=parseInt(diff/(1000*60*60*24));
                var diferenciaFecha=0;
                 
                if( pagada== 0){
                    if( ( dia -30 ) > 30 ){
                        return dia -30;
                    }else{
                        return "-";
                    }
                }else{
                    diferenciaFecha= dia - (pagada *30);
                    if( diferenciaFecha > 30){
                        return diferenciaFecha -30;
                    }else{
                        return "-"
                    }
                }
            }
        }
    })
</script>
@endsection

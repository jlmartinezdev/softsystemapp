@extends('layouts.app')
@section('title','Informe de Cuenta a Cobrar')
@section('style')
<style type="text/css">
   table td {
       font-size: 10pt;
       padding: 0px;
       /**/
   }
   .mystriped{
    background-color: rgba(0,0,0,.05);
   }
   .trsimple{
    line-height: 0.8em;
   }
</style>
@endsection
@section('main')
<div id="app">
    <div class="container">
        <div class="card">
            <div class="card-header bg-warning font-weight-bold">Informes de cuentas a cobrar</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" v-model="txtbuscar" @keyup.enter="buscar(false)" class="form-control" placeholder="Buscar...."/>
                            <div class="input-group-append">
                              <button class="btn btn-secondary" @click="buscar(false)">
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
                                    <input class="form-check-input" type="radio" value="cliente" v-model="filtro.busquedapor" name="busquedapor" id="defaultCheck1">
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
                                    <option value="8">Zona</option>

                                </select>
                            </div>
                            <div class="ml-2 border-left pl-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="ASC" @click="buscar(false)" name="orden" v-model="filtro.orden" id="defaultCheck3">
                                    <label class="form-check-label" for="defaultCheck3">
                                    ASC
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="DESC" @click="buscar(false)" v-model="filtro.orden" name="orden" id="defaultCheck4">
                                    <label class="form-check-label" for="defaultCheck4">
                                    DESC
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary btn-block"><span class="fa fa-print"></span> Vista Previa</button>
                    </div>
                </div>
                
            </div>    
        </div>
        <br>
        <table class="table table-sm">
            <tr>
                <th>Resultado de busqueda</th>
            </tr>
            <template v-for="(c,index) in ctas">
                <tr :class="{'mystriped': index % 2==0}">
                    <td>
                        <table class="table table-borderless table-sm">
                           
                            <tr class="mb-4">
                                <td><span class="fa fa-address-card text-secondary"></span> @{{ c.cliente_ruc }}</td>
                                <td colspan="2"><span class="fa fa-user text-secondary"></span> @{{ c.cliente_nombre }}</td>
                                <td colspan="2"><span class="fa fa-map-marker-alt text-secondary"></span> @{{ c.cliente_direccion}}</td>
                                <td><span class="fa fa-phone-alt text-secondary"></span> @{{ c.cliente_cel}}</td>
                            </tr>
                            <tr>
                                <th>Nro. Venta</th>
                                <th>Fecha Venta</th>
                                <th>Importe</th>
                                <th>Cobrado/ Cuota</th>
                                <th>Monto Cobrado</th>
                                <th>Saldo</th>
                            </tr>
                            <tr class="trsimple">
                                <td>@{{ c.nro_fact_ventas }}</td>
                                <td>@{{ c.venta_fecha }}</td>
                                <td>@{{ format(c.total)}}</td>
                                <td>@{{ c.pagada +" de "+ c.cuotas  }}</td>
                                <td>@{{ format(c.cobrado) }}</td>
                                <td>@{{ format(c.saldo)}}</td>
                            </tr>
                        </table>  
                    </td>
                </tr>    
            </template>
        </table>
    </div>

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
            error:''
        },
        methods:{
            buscar : function(p1){
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
                    this.ctas= response.data;
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
            }
        }
    })
</script>
@endsection
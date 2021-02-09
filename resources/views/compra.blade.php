@extends('layouts.app')
@section('title','Gestionar Compra')
@section('main')
<div id="app">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<div class="card">
					<div class="card-body">
						<div class="input-group">
			                <input type="text" v-model="txtbuscar" @keyup.enter="showBuscar()" class="form-control" placeholder="Buscar...." autofocus />
			                <div class="input-group-append">
			                  <button class="btn btn-secondary" @click="showBuscar()">
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
				</div>
				<!-- END CARD -->
				<div class="card mt-2">
					<table class="table table-striped table-sm table-responsive-sm">
						<tr>
							<th>Codigo</th>
							<th>Descripcion</th>
							<th>Cantidad</th>
							<th>Precio</th>
							<th>Importe</th>
							<th>Acciones</th>
						</tr>
						<template v-if="carro.length>0">
							<template v-for="(item,index) in carro">
								<tr>
								<td>@{{item.codigo}}</td>
								<td>@{{ item.descripcion }}</td>
								<td>@{{item.cantidad}}</td>
								<td>@{{new Intl.NumberFormat("de-DE").format(item.precio)}}</td>
								<td>@{{new Intl.NumberFormat("de-DE").format(item.precio * item.cantidad)}}</td>
								<td>
									<button class="btn btn-primary btn-sm" @click="setCantidad(index,item.cantidad,item.stock)" title="Modificar cantidad">
										<span class="fa fa-cubes"></span>	
									</button>
									<button class="btn btn-info btn-sm" @click="setPrecio(index,item)" title="Seleccionar precio">
										<span class="fa fa-dollar-sign"></span>	
									</button>
									<button class="btn btn-danger btn-sm" @click="delArticulo(item)" title="Quitar articulo">
										<span class="fa fa-times-circle"></span>	
									</button>
								</td>
								</tr>
							</template>
						</template>
						<template v-else>
							<tr><td colspan="6">S I N  &nbsp; A R T I C U L O  .  .  .</td></tr>
						</template>
						<tr>
							<td colspan="6" >
									<span class="text-muted"> Acciones: </span><span class="text-primary font-italic"><span class="fa fa-cubes"></span> Modificar Cantidad</span> <span class="text-muted"> |</span>
									<span class="text-info font-italic"><span class="fa fa-dollar-sign"></span> Modificar Precio </span><span class="text-muted"> |</span>
									<span class="text-danger font-italic"><span class="fa fa-times-circle"></span> Quitar de la lista </span>
									
							</td>
						</tr>
					</table>
				</div>
			</div>
			<!-- END DIV LEFT -->
			<div class="col-md-4">
				<div class="card">
					<div class="card-body">
						<div class="text-secondary text-center">
								<span class="badge badge-default"><span class="fa fa-cash-register"></span> CAJA </span><span class="badge badge-pill " :class="[ caja=='ABIERTA' ? 'badge-success pr-2 pl-2' : 'badge-danger' ]">  @{{caja}} </span> |<span class="badge badge-default"><span class="fa fa-info-circle"></span> NRO OPERACION </span><span class="badge badge-pill " :class="[ caja=='ABIERTA' ? 'badge-success' : 'badge-danger' ]">  @{{nrooperacion}} </span>
							
						</div>
						<hr>
						
						<fieldset class="form-group">
							<label>Fecha</label>
							<input type="date" class="form-control form-control-sm"  placeholder="Fecha">
						</fieldset>
					
						<fieldset class="form-group">
							<label>Proveedor</label>
							<div class="input-group">
								<input type="text" disabled class="form-control form-control-sm" placeholder="Nombre Cliente" >
				                <div class="input-group-append">
				                  <button class="btn btn-secondary btn-sm">	
				                       <span class="fa fa-user"></span> Buscar
				                    </button>
				                </div>
				            </div>
						</fieldset>
						<fieldset class="form-group">
							<label for="factura">Nro. Factura</label>
							<div class="input-group">
								<input type="text" class="form-control form-control-sm">
								<input type="text" class="form-control form-control-sm">
								<input type="text" class="form-control form-control-sm">
							</div>
						</fieldset>

						<fieldset class="form-group">
							<label>Descuento</label>
							<input type="number" class="form-control form-control-sm" placeholder="Descuento...">
						</fieldset>
						<hr>
						<h3>TOTAL: @{{totalCompra}}</h3>
						<hr>
						<button class="btn btn-success btn-block">
							<span class="fa fa-check"></span>
							<strong>FINALIZAR</strong> 
						</button>
				</div>
			</div>
			
		</div>
	</div>
	<busqueda :articulo_sel="validarArticulo($event)"></busqueda>
</div>

@endsection
@section('script')
<script src="{{ mix('js/busqueda.js')}}"></script>
<script type="text/javascript">
	var app=new Vue({
	el: '#app',
	data: {
		txtbuscar: '',
		requestSend: false,
		requestLote: false
		carro: [],
		articulos: [],
		stocks: [],
		requestLote: false,
		compraCabecera: {fecha: '2021-01-01',idproveedor:1,idSucursal: 1,factura_n1:0,factura_n2:0,factura_n3:0,total:0,descuento:0	},
		caja : '...',
		nrooperacion: '...',
	},
	methods:{
		format: function(numero){
			return new Intl.NumberFormat("de-DE").format(numero);
		},
		showBuscar: function(){
			$('#busquedaArticulo').modal('show');
			//this.buscar(false);
		},
		validarArticulo: function(articulo){
			if(a.cantidad == 0) {
		  			Swal.fire('Articulo en stock 0','No se puede agregar este articulo!','error');
		  			return;
		  		}
		  		this.requestLote= true;
		  		//Traer lotes
		  		axios.get('{{env("APP_APIDB")}}',{params:{ lote : a.ARTICULOS_cod, bus_suc : this.ventaCabecera.idSucursal}})
        		.then(response =>{
        			const stocks= response.data;
        			this.requestLote= false;
        			if(stocks.length>1){ //Si hay mas de un lote
        				$('#busquedaArticulo').modal('hide');
        				this.validarLote(a,stocks); 
        			}else{
        				this.addCarrito(a,stocks[0].id_stock);
						$('#busquedaArticulo').modal('hide');
        			}
        		})
		  		
		},
		calcula_totales: function(){

		},
		set_cantidad: function(){

		},
		finalizar: function(){

		},
		get_historial: function(){

		},
		onChange: function(){

		}
		
	},
	computed: {
		totalCompra: function(){
			this.compraCabecera.total=0;
			for (var i = 0; i < this.carro.length; i++) {
				this.compraCabecera.total += (this.carro[i].precio * this.carro[i].cantidad);
			}
			if(this.compraCabecera.descuento > 0 && this.compraCabecera.total > 0){
				this.compraCabecera.total -=  this.compraCabecera.descuento;
			}
			return this.format(this.compraCabecera.total);
			
		}

	}
})
</script>


@endsection
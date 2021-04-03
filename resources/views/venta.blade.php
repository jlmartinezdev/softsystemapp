@extends('layouts.app')
@section('title','Gestionar Venta')
@section('style')
<style type="text/css">
	.form-group{
		margin-bottom: 7px;
	}
	.form-group label{
		margin-bottom: 0.2rem;
		font-weight: bold;
	}

</style>
@endsection
@section('main')
	<div id="app">
		<div >
			<div class="row" >
			<!-- PANEL IZQUIERDA -->
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
					<!-- TABLA ......................... -->
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
			<!-- PANEL DERECHA  -->
			<div class="col-md-4">
				<div class="card">
					<div class="card-body">
						<div class="text-secondary text-center">
								<span class="badge badge-default"><span class="fa fa-cash-register"></span> CAJA </span><span class="badge badge-pill " :class="[ caja=='ABIERTA' ? 'badge-success pr-2 pl-2' : 'badge-danger' ]">  @{{caja}} </span> |<span class="badge badge-default"><span class="fa fa-info-circle"></span> NRO OPERACION </span><span class="badge badge-pill " :class="[ caja=='ABIERTA' ? 'badge-success' : 'badge-danger' ]">  @{{nrooperacion}} </span>
							
						</div>
						<hr>
						<fieldset class="form-group">
							<label>Documento</label>
							<select class="form-control form-control-sm" v-model="ventaCabecera.documento">
								<option value="Ticket">Ticket</option>
								<option value="Comprobante">Comprobante de Venta</option>
								<option value="Factura">Factura</option>
							</select>
						</fieldset>	
						<fieldset class="form-group">
							<label>Fecha</label>
							<input type="date" class="form-control form-control-sm" v-model="ventaCabecera.fecha" placeholder="Fecha">
						</fieldset>
					
						<fieldset class="form-group">
							<label>Cliente</label>
							<div class="input-group">
								<input type="text" disabled class="form-control form-control-sm" placeholder="Nombre Cliente" v-model="ventaCabecera.clienteNombre">
				                <div class="input-group-append">
				                  <button class="btn btn-secondary btn-sm" @click="showBuscarCliente()">	
				                       <span class="fa fa-user"></span> Buscar
				                    </button>
				                </div>
				            </div>
						</fieldset>

						<fieldset class="form-group">
							<label>Descuento</label>
							<input type="number" @keyup="saveDatos" class="form-control form-control-sm" v-model="ventaCabecera.descuento" placeholder="Descuento...">
						</fieldset>
						<hr>
						<h3>TOTAL: @{{totalVenta}}</h3>
						<hr>
						<button class="btn btn-success btn-block" @click="showFinalizar">
							<span class="fa fa-check"></span>
							<strong>FINALIZAR</strong> 
						</button>
				</div>
			</div>
			</div>
		</div> <!-- end row -->
		</div> <!--end container -->
		@include('articulo.buscar')
		@include('venta.finalizar')
		@include('cliente.buscar')
	</div><!-- end app -->
@endsection
@section('footer')
	<div class="bg-dark fixed-bottom text-white">
		<div class="container">
			<span class="fa fa-user"></span> Usuario: {{ Auth::user()->nom_usuarios }}
			<span class="ml-3">{{date('d-m-Y')}}</span>
		</div>
	</div>
@endsection
@section('script')
<script src="{{ mix('js/venta.js')}}"></script>
<script type="text/javascript">
	var app= new Vue({
		el: '#app',
		data: {
			requestSend:false,
			currentPage: 1,
		    bootstrapPaginationClasses: { ul: 'pagination',li: 'page-item',liActive: 'active',liDisable: 'disabled', button: 'page-link'},
		    customLabels: { first: 'Primer', prev: 'Ant',next: 'Sig', last: 'Ultimo' },
		    paginacion: {'total': 0,'pagina_actual': 1, 'por_pagina': 0,'ultima_pagina': 0,'desde': 0,'hasta': 0 },
			ventaCabecera: {fecha: '2020-01-01', clienteId: '1', clienteNombre:'Ocasional', documento: 'Ticket',idSucursal: 1,formacobro:1,condicionventa: 1, total: 0,descuento: 0,nro_operacion:0},
			carro:[],
			caja: '...',
			nrooperacion: '...',
			txtbuscar: '',
			txtcliente: '',
			filtro: {seccion: 0, columna: 0, orden: 'ASC'},
			error:'',
			articulos:[],
			clientes:[],
			requestLote: false
		},
		methods:{
			onChange: function () {//Al cambiar pagina
		      if(this.paginacion.ultima_pagina > 1){
		         this.buscar(true);
		      }
		    },
			buscar: function(isPaginate){
		        this.requestSend= true;
		        if(this.txtbuscar.length == 0) {
		        	let pag= isPaginate? this.currentPage: 1
			  		axios.get('articulo/buscar',{
			          params:{page:pag,buscar:this.txtbuscar,criterio:0,seccion:this.filtro.seccion,col:this.filtro.columna,ord:this.filtro.orden,suc:this.ventaCabecera.idSucursal}
			        })
				  	.then(response=>{
			          this.requestSend= false;
			          if(response.data=='NO'){
			            Swal.fire('No se encontrado resultado!','Para:  '+this.txtbuscar, 'info' );
			          }else{
			            this.articulos= response.data.articulos.data;
			            this.paginacion= response.data.paginacion;
			            //this.paginacion.pagina_actual=1;
			          }
				  			//this.error=response.data;
				  	})
			  		.catch(e=>{
		          		this.requestSend= false;
			  			this.error= e.message;
			  		});
		        }else{
		        	axios.get('{{env("APP_APIDB")}}',{
		        		params: {buscar: this.txtbuscar,bus_suc:this.ventaCabecera.idSucursal}
		        	})
		        	.then( response => {
		        		this.requestSend= false;
		        		if(response.data!="no"){
		        			this.articulos= response.data;
		        		}else{
		        			this.articulos= [];
		        		}
		        		
		        	})
		        	.catch(error => {
		        		Swal.fire('Error',error.message,'error');
		        	});
		        }
			        
		  	},
		  	showBuscar: function(){
		  		var t=parseFloat(this.txtbuscar);
		  		if(isNaN(t)){
		  			$('#busquedaArticulo').modal('show');
		  			this.buscar(0);
		  		}else{
		  			axios.get('{{env("APP_APIDB")}}',{params:{cbarra:this.txtbuscar,bus_suc: this.ventaCabecera.idSucursal}})
		  			.then(response => {
		  				const articulo= response.data;
		  				if(articulo !="no"){
		  					if(articulo.length > 1)
		  						this.validarLote(articulo[0],articulo);
		  					else
		  						this.addCarrito(articulo[0],articulo[0].id_stock);
		  				}
		  				else
		  					Swal.fire('Atención..','Codigo ingresado no existe en la Base de Datos...','warning')
		  			})
		  			.catch(error =>{
		  				console.log(error.message)
		  			})
		  		}
		  		
		  	},
		  	validarArticulo: function(a){
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
		  		this.txtbuscar='';
		  		
		  	},
		  	addCarrito: function(a,idStock){
		  		//Buscar articulo si no esta en la lista
				let i=this.carro.findIndex(x=> x.codigo == a.ARTICULOS_cod &&  x.idstock==idStock);
				if(i == -1){
					let art= {
			  			codigo: a.ARTICULOS_cod, 
	  					idstock: idStock,
	  					descripcion: a.producto_nombre,
	  					cantidad: 1,
	  					stock: a.cantidad,
	  					precio: a.pre_venta1,
	  					p1: a.pre_venta1,
	  					p2: a.pre_venta2,
	  					p3: a.pre_venta3,
	  					p4: a.pre_venta4}
			  		this.carro.push(art);
				}else{
					this.carro[i].cantidad= parseInt(this.carro[i].cantidad) + 1;//Actualizar cantidad
				}
			  	this.saveDatos();
		  	},
            getFecha: function() {

                var f = new Date();
                var dia =  f.getDate();
                var mes = (f.getMonth() + 1);
                this.ventaCabecera.fecha= f.getFullYear() + "-" + mes.toString().padStart(2, "0") + "-" + dia.toString().padStart(2, "0");
                //this.filtrovalue= this.meses[mes];
            },
            setCantidad: async function(index,cantidad,stock){
            	const swalBootstrap = Swal.mixin({
				  customClass: {
				    confirmButton: 'btn btn-primary mr-2',
				    cancelButton: 'btn btn-danger'
				  },
				  buttonsStyling: false
				})
            	const { value: cant } = await swalBootstrap.fire({
				  title: 'Escriba cantidad a Vender...',
				  input: 'number',
				  inputValue: cantidad,
				  inputAttributes: { min :0 , max : stock},
				  showCancelButton: true,
				  confirmButtonText: 'Aceptar',
				  cancelButtonText: 'Cancelar'
				})
				if (cant) {
				  this.carro[index].cantidad= cant;
				  this.saveDatos();
				}
            },
            setPrecio: async function(index,articulo){
            	var preselect=0;
            	const { value: precio } = await Swal.fire({
					title: 'Seleccione Precio',
					input: 'select',
					inputOptions: {
					1 : this.format(articulo.p1),
					2 : this.format(articulo.p2),
					3 : this.format(articulo.p3),
					4 : this.format(articulo.p4),
					},
					inputPlaceholder: 'Seleccione precio',
					showCancelButton: true,
					confirmButtonText: 'Aceptar',
				  	cancelButtonText: 'Cancelar'
					})
            	if(precio){
            		switch(precio){
            			case '1':
            			preselect= articulo.p1;
            			break;
            			case '2':
            			preselect= articulo.p2;
            			break;
            			case '3':
            			preselect= articulo.p3;
            			break;
            			case '4':
            			preselect= articulo.p4;
            			break;
            		}
            		this.carro[index].precio= preselect;
            		this.saveDatos();
            	}
            },
            delArticulo: function(articulo){
            	this.carro.pop(articulo);
            	this.saveDatos();
            },
            format: function(numero){
            	return new Intl.NumberFormat("de-DE").format(numero);
            },
            getApertura: function(){
            	let idSucursal= $('#sucursal').attr('data-id');
            	this.ventaCabecera.idSucursal=idSucursal;
            	if(idSucursal != null){
            		axios.get('/aperturacierre/'+idSucursal)
            		.then(response =>{
            			if(response.data){
            				this.nrooperacion= response.data.nro_operacion;
            				this.ventaCabecera.nro_operacion= response.data.nro_operacion;
            				this.caja= 'ABIERTA';
            			}else{
            				this.caja= 'CERRADA';
            			}
            		})
            		.catch(error =>{
            			console.log(error);
            		})
            	}
            },
            showFinalizar:function(){
            	if(this.caja=='ABIERTA'){
            		if(this.ventaCabecera.total > 0){
            			$('#finalizarventa').modal('show');
            		}
            	}else{
            		Swal.fire('Atención...','Caja no esta abierta!','warning');
            	}
            	
            },
            finalizar: function(){
            	
            	axios.post('venta',{ventaCabecera: this.ventaCabecera, detalle: this.carro})
            	.then(response =>{
            		console.log(response.data);
            		this.carro= [];
            		localStorage.removeItem('carro_venta');
            		localStorage.removeItem('ventaCabecera');
            		$('#finalizarventa').modal('hide');
            	})
            	.catch(error =>{
            		Swal.fire('Error',error.message,'error');
            	})
            	
            },
            numeroaletra: function(n){
            	return NumeroALetras.NumeroALetras(n);
            },
            saveDatos: function(){
            	localStorage.setItem('carro_venta',JSON.stringify(this.carro));
            	localStorage.setItem('ventaCabecera',JSON.stringify(this.ventaCabecera));
            },
            recuperarDatos: function(){
            	var carro= localStorage.getItem('carro_venta');
            	if(carro != null){
            		this.carro= JSON.parse(carro);
            	}
            	var cab = localStorage.getItem('ventaCabecera');
            	if(cab != null){
            		this.ventaCabecera= JSON.parse(cab);
            	}
            },
            showBuscarCliente: function(){
            	$('#busquedaCliente').modal('show');
            },
            buscarCliente: function(){
            	if(this.txtcliente.length > 0){
            		var doc= '';
            		var nom= '';
            		if(isNaN(parseFloat(this.txtcliente))){
            			nom= this.txtcliente;
            		}else{
            			doc= this.txtcliente;
            		}
            		axios.get('cliente/buscar',{params:{documento: doc,nombre: nom }})
            		.then(response =>{
            			this.clientes= response.data;
            		})
            		.catch(error =>{
            			console.log(error.message);
            		})
            	}
            },
            selectCliente: function(id,cliente){
            	this.ventaCabecera.clienteId=id;
            	this.ventaCabecera.clienteNombre= cliente;
            	$('#busquedaCliente').modal('hide');
            },
            getSucursal: function(){
            	var obj= document.getElementById("sucursal");
				if(obj.getAttribute('data-id')!= null)
					this.ventaCabecera.idSucursal= obj.getAttribute('data-id');
            },
            validarLote:async function(articulo,lotes){
            	var values= {};
            	for (var i = 0; i < lotes.length; i++) {
            		values[i]=lotes[i].lote_nro;
            	}
            	const { value: lote } = await Swal.fire({
					title: 'Seleccione Lote',
					input: 'select',
					inputOptions: values,
					inputPlaceholder: 'Seleccione lote',
					showCancelButton: true,
					confirmButtonText: 'Aceptar',
				  	cancelButtonText: 'Cancelar'
					})
            	if(lote){
            		this.addCarrito(articulo,lotes[lote].id_stock);
            	}
            }
		},
		computed: {
			totalVenta: function(){
				this.ventaCabecera.total=0;
				for (var i = 0; i < this.carro.length; i++) {
					this.ventaCabecera.total += (this.carro[i].precio * this.carro[i].cantidad);
				}
				if(this.ventaCabecera.descuento > 0 && this.ventaCabecera.total > 0){
					this.ventaCabecera.total -=  this.ventaCabecera.descuento;
				}
				return this.format(this.ventaCabecera.total);
				
			}

		},
		mounted(){
			this.getFecha();
			this.getApertura();
			this.recuperarDatos();
			this.getSucursal();
		}
	});
</script>
@endsection
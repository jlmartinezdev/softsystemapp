@extends('layouts.app')
@section('title','Cliente')
@section('main')
<div class="container" id="app">
	<div class="row">
		<div class="col-2">
			<button class="btn btn-primary" data-toggle="modal" data-target="#agregarCliente"><span class="fa fa-plus"></span> Agregar</button>
		</div>
		<div class="col-10">
			<div class="input-group">
		        <input type="text" v-model="txtbuscar" @keyup.enter="buscar()" class="form-control" placeholder="Buscar...."/>
		        <div class="input-group-append">
		          <button class="btn btn-secondary" @click="buscar()">
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
			

      <br>
      <br>
      <table class="table table-striped table-sm">
      	<tr>
      		<th>Documento</th>
      		<th>Nombre y Apellido</th>
      		<th>Direccion</th>
      		<th>Celular</th>
      		<th>Acciones</th>
      	</tr>
      	<template v-for="cliente in clientes">
    		<tr>
    			<td>@{{cliente.cliente_ci}}</td>
    			<td>@{{cliente.cliente_nombre}}</td>
    			<td>@{{cliente.cliente_direccion}}</td>
    			<td>@{{cliente.cliente_cel}}</td>
    			<td>
    				<button class="btn btn-outline-primary btn-sm" @click="showEdit(cliente)" title="Seleccionar">
    					<span class="fa fa-edit"></span>
    				</button>
    				<button class="btn btn-outline-danger btn-sm" @click="del(cliente.cliente_nombre,cliente.clientes_cod)" title="Seleccionar">
    					<span class="fa fa-trash"></span>
    				</button>

    			</td>
    		</tr>
    	</template>
      </table>
      @include('cliente.agregar')
      @include('cliente.editar')
</div>
@endsection
@section('script')
<script type="text/javascript">
	var app= new Vue({
		el: '#app',
		data: {
			clientes: [],
			requestSend: false,
			cliente: {id:'',doc:'',nombre:'',direccion:'',celular:'',correo:'',idciudad:'1'},
			txtbuscar: ''
		},
		methods: {
			buscar: function(){
				requestSend= true;
        		var doc= '';
        		var nom= '';
        		if(isNaN(parseFloat(this.txtbuscar))){
        			nom= this.txtbuscar;
        		}else{
        			doc= this.txtbuscar;
        		}
        		axios.get('cliente/buscar',{params:{documento: doc,nombre: nom }})
        		.then(response =>{
        			requestSend= false;
        			this.clientes= response.data;
        		})
        		.catch(error =>{
        			console.log(error.message);
        		})
            	
			},
			showAdd: function(){
				$('#agregarCliente').modal('show');
			},
			showEdit: function(c){
				this.cliente= {id:c.clientes_cod,doc:c.cliente_ci,nombre:c.cliente_nombre,direccion:c.cliente_direccion,celular:c.cliente_cel,correo:c.cliente_correo ,idciudad:c.ciudad_cod};
				$('#editarCliente').modal('show');
			},
			del: function(nombre,id){
				Swal.fire({
			        title: '¿Desea eliminar este cliente?',
			        text: nombre,
			        icon: 'question',
			        showCancelButton: true,
			        //confirmButtonColor: 'btn-danger',
			        //cancelButtonColor: 'btn-secondary',
			        cancelButtonText: 'Cancelar',
			        confirmButtonText: 'Si, eliminar!',
			        confirmButtonClass: 'bg-danger'
			      }).then((result) => {
			        if (result.value) {
			          axios.delete('cliente/'+id)
			          .then(r=>{
			            Swal.fire(
			              'Eliminado!',
			              'El registro ha sido eliminado.',
			              'success'
			            )
			            location.reload();
			          }).catch(e=>{
			          	Swal.fire(
			              'No se puede eliminar!',
			              'Este cliente esta registrada en venta...',
			              'error'
			            )
			          });
			        }
			      })
			},
			save: function(){
				if(this.cliente.nombre.length>0 && this.cliente.doc.length>0 ){
					axios.post('cliente',{
						cliente: this.cliente
					})
					.then(response =>{
						location.reload();
					})
					.catch( error =>{
						console.log(error.message);
					})
				}else{
					Swal.fire('Campos Vacios!','Complete Documento y Nombres...','wargnig');
				}
			},
			update: function(c){
				
				axios.post('cliente/update',{cliente: this.cliente})
				.then(response =>{
					location.reload();
				})
				.catch(error =>{
					console.log(error.message);
				})
			}

		},
		mounted(){
			this.buscar();
		}
	})
</script>
@endsection
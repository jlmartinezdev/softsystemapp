@extends('layouts.app')
@section('title','Usuarios')
@section('main')
<div class="container" id="app">
	<div class="card">
		<div class="card-body">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<strong>Nombre</strong>
						<input class="form-control form-control-sm" type="text" placeholder="Nombre de Usuario" v-model="user.nombre" />
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<strong>Celular</strong>
						<input class="form-control form-control-sm" type="text" placeholder="Celular..." v-model="user.celular" />
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<strong>Dirección</strong>
						<input class="form-control form-control-sm" type="text" placeholder="Dirección..." v-model="user.direccion"/>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<strong>Usuario</strong>
						<input class="form-control form-control-sm" type="text" placeholder="Usuario..." v-model="user.usuario" />
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<strong>Contraseña</strong>
						<input class="form-control form-control-sm" type="password" placeholder="Contraseña..." v-model="user.password" />
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<strong>Rol</strong>
						<select class="form-control form-control-sm" v-model="user.rol">
							@foreach($roles as $r)
							<option value="{{$r->cod_rol}}">{{$r->nom_rol}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<strong>Cargo</strong>
						<select class="form-control form-control-sm" v-model="user.cargo">
							@foreach($cargo as $c)
							<option value="{{$c->cod_cargo}}">{{$c->nom_cargo}}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="card-footer">
			<button class="btn btn-success" @click="save">
				<span class="fa fa-save"></span>
				<template v-if="user.band=='0'">
				Agregar	
				</template>
				<template v-else>
				Actualizar
				</template>
			</button>
			<button class="btn btn-secondary" @click="reset"><span class="fa fa-reply"></span> Cancelar</button>
		</div>
	</div>
	<div class="card">
		<div class="card-body">
			<table class="table table-striped table-sm">
				<tr>
					<th>#</th>
					<th>Nombre</th>
					<th>Usuario</th>
					<th>Direccion</th>
					<th>Seleccionar</th>
				</tr>
				@foreach($usuario as $u)
				<tr>
					<td>{{ $loop->iteration }}</td>
					<td>{{ trim($u['nom_usuarios']) }}</td>
					<td>{{ trim($u['user_usuarios']) }}</td>
					<td>{{ trim($u['direcc_usuarios']) }}</td>
					<td>
						<button class="btn btn-sm btn-outline-primary" @click="edit({{$u}})"><span class="fa fa-edit"></span></button>
						<button class="btn btn-sm btn-outline-danger" @click="del('{{trim($u['nom_usuarios'])}}',{{$u['cod_usuarios']}})"><span class="fa fa-trash"></span></button>

					</td>
				</tr>
				@endforeach
			</table>
		</div>
	</div>
</div>
@endsection
@section('script')
<script type="text/javascript">
	var app= new Vue({
		el: '#app',
		data: {
			user:{codigo:'',nombre:'',celular:'',direccion:'',usuario:'',password:'',rol:1,cargo:1,band:0}
		},
		methods:{
			save: function(){
				if(this.user.nombre && this.user.usuario){
					if(this.user.band==0 && !this.user.password){
						Swal.fire('Atencion...','Complete contraseña...','warning');
						return;
					}
					axios.post('usuario',this.user)
					.then(response =>{
						location.reload();
					})
					.catch(error =>{
						console.log(error.message)
					})
				}else{
					Swal.fire('Atencion...','Complete Campos!','warning');
				}
				
			},
			edit: function(u){
				this.user.band=1;
				this.user.codigo= u.cod_usuarios;
				this.user.nombre= u.nom_usuarios;
				this.user.celular= u.tel_usuarios;
				this.user.direccion= u.direcc_usuarios;
				this.user.usuario= u.user_usuarios;
				this.user.rol= u.cod_rol
				this.user.cargo= u.cod_cargo
			},
			reset: function(){
				this.user= {nombre:'',celular:'',direccion:'',usuario:'',rol:1,cargo:1,band:0};
			},
			del: function(nombre,id){
				Swal.fire({
			        title: '¿Desea eliminar este Usuario?',
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
			          axios.delete('usuario/'+id)
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
			}
		},
		mounted(){

		}
	})
</script>
@endsection
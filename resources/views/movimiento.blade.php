@extends('layouts.app')
@section('title','Moviemiento de Caja')
@section('main')
	<div class="container" id="app">
		<div class="card border-info">
			<h5 class="card-header bg-info text-white">Movimiento de caja</h5>
			<div class="card-body">
				
				<h5><span class="badge badge-warning"> CAJA: <strong>@{{ this.movimiento.caja}}</strong></span> | <span class="badge badge-secondary"> NRO. OPERACION: <strong>@{{ this.movimiento.nro_operacion }}</strong></span> | 
				<span class="badge"><strong>EN CAJA:</strong> @{{ encaja }}</span>
				</h5>
			<hr>
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<strong>TIPO</strong>
							<select class="form-control form-control-sm" v-model="movimiento.tipo" autofocus="autofocus" tabindex="1" id="tipo" v-on:keyup.enter="$event.target.nextElementSibling.focus()">
								<option value="Entrada">ENTRADA ++</option>
								<option value="Salida">SALIDA --</option>
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<strong >DESCRIPCION</strong>
							<input type="text" class="form-control form-control-sm" placeholder="Descripcion" v-model="movimiento.descripcion" tabindex="2">
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<strong >MONTO</strong>
							<input type="number" min="0" step="1000" class="form-control form-control-sm" placeholder="Monto" v-model="movimiento.monto" tabindex="3">
						</div>
					</div>	
					<div class="col-md-3 pt-4">
						<button class="btn btn-primary btn-block btn-sm" @click="store" tabindex="4"><span class="fa fa-save"></span> GUARDAR</button>
					</div>	
				</div>
			</div>
		</div>
		<div class="card mt-2">
			<table class="table table-sm table-striped">
				<tr>
					<th>#</th>
					<th>Tipo</th>
					<th>Fecha - Hora</th>
					<th>Descripcion</th>
					<th>Monto</th>
				</tr>
				<template v-for="(m,i) in movimientos">
					<tr :class="[m.mov_tipo=='Entrada' ? 'text-success' : 'text-danger']">
						<td>@{{ i+1}}</td>
						<td>@{{m.mov_tipo }} 
							<template v-if="m.mov_tipo=='Entrada'">
								<span class="fa fa-arrow-left"></span>
							</template>
							<template v-else>
								<span class="fa fa-arrow-right"></span>
							</template>
						</td>
						<td>@{{m.mov_fecha }}</td>
						<td>@{{m.mov_concepto }}</td>
						<td class="text-right">
							<strong>@{{new Intl.NumberFormat("de-DE").format(m.mov_monto)}} </strong>
							
						</td>
					</tr>
				</template>
			</table>
		</div>
	</div>
@endsection
@section('script')
<script type="text/javascript">
	var app= new Vue({
		el: '#app',
		data: {
			movimientos: [],
			movimiento: {idSucursal: 0,nro_operacion: '-',caja: '-',tipo:'Entrada',descripcion: '',monto: ''}
		},
		methods: {
			getApertura: function(){
				let idSucursal= $('#sucursal').attr('data-id');
            	this.movimiento.idSucursal=idSucursal;
            	if(idSucursal != null){
            		axios.get('/aperturacierre/'+idSucursal)
            		.then(response =>{
            			if(response.data){
            				this.movimiento.nro_operacion= response.data.nro_operacion;
            				this.movimiento.caja= 'ABIERTA';
            				this.getMovimiento();
            			}else{
            				this.movimiento.caja= 'CERRADA';
            			}
            		})
            		.catch(error =>{
            			console.log(error);
            		})
            	}
            	$("#tipo").focus();
			},
			getMovimiento: function(){
				if(this.movimiento.nro_operacion != '-'){
					axios.get('movimiento/'+this.movimiento.nro_operacion)
					.then(response =>{
						this.movimientos= response.data;
					})
					.catch(error =>{
						console.log(error.message);
					})
				}
			},
			store: function(){
				if(this.movimiento.caja=='ABIERTA'){
					if(this.movimiento.descripcion.length > 0 && this.movimiento.monto > 0){
						axios.post('movimiento',{data : this.movimiento})
						.then(response =>{
							this.movimiento.descripcion= '';
							this.movimiento.monto= '';
							this.movimientos= response.data;
							Swal.fire('Correcto!','Agregado correctamente','success');
						})
						.catch(response =>{
							console.log(response.message);
						})
					}else{
						Swal.fire('Complete los campos!','No hay datos para guardar...','warning');
					}
				}else{
					Swal.fire('Caja No esta Abierta!','No se puede guardar movimiento...','warning');
				}
			}
		},
		computed: {
			encaja: function(){
				var total= 0;
				for (var i = 0; i < this.movimientos.length; i++) {
					if(this.movimientos[i].mov_tipo=='Entrada'){
						total += parseInt(this.movimientos[i].mov_monto);
					}else{
						total -= parseInt(this.movimientos[i].mov_monto);
					}
				}
				return new Intl.NumberFormat("de-DE").format(total);
			}
		},
		mounted(){
			this.getApertura();

			
		}
	})
</script>
@endsection
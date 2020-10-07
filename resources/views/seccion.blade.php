@extends('layouts.app')
@section('title','Secciones')
@section('main')
	<div class="container" id="app">
		<div class="card">
			<div class="card-header bg-info text-white">Secciones</div>
			<div class="card-body">
				<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							<strong>Descripcion</strong>
							<input type="text" class="form-control form-control-sm" name="descripcion" placeholder="Descripcion seccion" v-model="descripcion">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<strong>Impuesto</strong>
							<select class="form-control form-control-sm" v-model="iva">
								<option value="0">Exenta</option>
								<option value="5">Iva 5%</option>
								<option value="10">Iva 10%</option>
							</select>
						</div>
					</div>
					<div class="col-sm-4 mt-4">
						<button class="btn btn-success btn-block btn-sm" @click="add"><span class="fa fa-save"></span> Agregar</button>
					</div>
				</div>
			<hr>
			<table class="table table-sm table-striped">
				<tr>
					<th>#</th>
					<th>Descripcion</th>
					<th>Impuesto</th>
					<th>Acciones</th>
				</tr>
				@foreach($secciones as $s)
				<tr>
					<td>{{$loop->iteration}}</td>
					<td>{{$s['present_descripcion']}}</td>
					<td>{{$s['iva']}}</td>
					<td>
						<button class="btn btn-outline-danger btn-sm" @click="del({{$s['present_cod']}},'{{ trim($s['present_descripcion'])}}')" ><span class="fa fa-trash"></span></button>
						<button @click="showEdita({{$s['present_cod']}},'{{ trim($s['present_descripcion'])}}',{{$s['iva']}})" class="btn btn-outline-primary btn-sm" ><span class="fa fa-edit"></span></button>
					</td>
				</tr>
				@endforeach
			</table>
			</div>
		</div>

		<div class="modal fade" id="edit">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Editar</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							<span class="sr-only">Cerrar</span>
						</button>
						
					</div>
					<div class="modal-body">
						<div class="form-group">
							<strong>Descripcion</strong>
							<input type="text" class="form-control form-control-sm" placeholder="Descripcion seccion" v-model="e_descripcion">
						</div>
						<div class="form-group">
							<strong>Impuesto</strong>
							<select class="form-control form-control-sm" v-model="e_iva">
								<option value="0">Exenta</option>
								<option value="5">Iva 5%</option>
								<option value="10">Iva 10%</option>
							</select>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
						<button type="button" class="btn btn-primary" @click="update" >Guardar cambio</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	</div>
@endsection
@section('script')
<script type="text/javascript">
	function del(id){
		
	}
	var app= new Vue({
		el: '#app',
		data:{
			descripcion: '',
			iva: 10,
			e_codigo: '',
			e_descripcion: '',
			e_iva:''
		},
		methods:{
			add: function(){
				if(this.descripcion.length > 0 ){
					axios.post('seccion',{descripcion: this.descripcion, iva: this.iva})
					.then(response => {
						location.reload();
					})
					.catch( error => {
						console.log(error.message);
					})
				}else{
					Swal.fire('Campo vacio!','Complete campo para agregar...','wargning');
				}
			},
			showEdita: function(id,descripcion,iva){
				this.e_codigo= id;
				this.e_descripcion= descripcion;
				this.e_iva= iva;
				$('#edit').modal('show');
			},
			del: function(id,descripcion){
				Swal.fire({
			        title: '¿Desea eliminar este registro?',
			        text: descripcion,
			        icon: 'question',
			        showCancelButton: true,
			        //confirmButtonColor: 'btn-danger',
			        //cancelButtonColor: 'btn-secondary',
			        cancelButtonText: 'Cancelar',
			        confirmButtonText: 'Si, eliminar!',
			        confirmButtonClass: 'bg-danger'
			      }).then((result) => {
			        if (result.value) {
			          axios.delete('seccion/'+id)
			          .then(r=>{
			            Swal.fire(
			              'Eliminado!',
			              'El registro ha sido eliminado.',
			              'success'
			            )
			            location.reload();
			          }).catch(e=>{console.log(e.message);});
			        }
			     })
			},
			update: function(){
				if(this.e_descripcion.length > 0){
					axios.post('seccion/'+this.e_codigo,{'descripcion': this.e_descripcion,'iva':this.e_iva})
					.then(response =>{
						location.reload();
					})
					.catch(error =>{
						console.log(error.message);
					})
				}
			}

		}
	})
</script>
@endsection
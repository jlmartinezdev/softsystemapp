@extends('layouts.app')
@section('title','Establecer sucursal')
@section('main')
<div class="container">
	<div class="card">
		<div class="card-header">
			<strong>Establecer Sucursal</strong>
		</div>
		<div class="card-body">
			<ul class="list-inline">
			@foreach($sucursales as $sucursal)
			<li>
				<label class="font-weight-bold"><input type="radio" value="{{$sucursal['suc_cod']}}" data-descripcion="{{$sucursal['suc_desc']}}" name="sucursal" id="sucursal" class="custom-radio"> {{$sucursal['suc_desc']}}</label>
			</li>
			@endforeach
		</ul>
		</div>
		<div class="card-footer">
			<button class="btn btn-success" onclick="setSucursal()"><span class="fa fa-save"></span> ESTABLECER</button>
		</div>
	</div>
</div>

@endsection
@section('script')
<script type="text/javascript">
	function setSucursal(){
		var obj= document.getElementsByName("sucursal");
		var descripcion= "";
		var id= "";
		for(var i=0; i<obj.length ; i++){ 
			if(obj[i].checked){
				descripcion= obj[i].getAttribute('data-descripcion');
				id= obj[i].value;
				break;
			}
		}
		localStorage.setItem("suc_desc",descripcion);
		localStorage.setItem("suc_cod",id);
		Swal.fire('Informacion!','Se ha esteblecido sucursal!', 'success' );
		window.getSucursal();
	}
	function checkSucursal(){
		var id= localStorage.getItem("suc_cod");
		if(id != null){
			var obj= document.getElementsByName("sucursal");
			for(var i=0; i<obj.length ; i++){
				if(obj[i].value== id){
					obj[i].checked= true;
				}
			}
		}
	}
	checkSucursal();
</script>
@endsection
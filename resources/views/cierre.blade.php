@extends('layouts.app')
@section('title','Cierre de Caja')
@section('main')
<div class="container">
	<div class="card border-info">
		<form method="POST" action="{{route('apertura.close')}}">
		@csrf
		
		<div class="card-header bg-info text-white">
			<h4>Cierre Caja - Numero de Operacion: {{$apertura[0]['nro_operacion']}}</h4> 
		</div>
		<div class="card-body">

			<div class="row">
				<div class="col-sm-3">
					<input type="hidden" name="nro_operacion" value="{{$apertura[0]['nro_operacion']}}">
					<ul class="list-inline">
						<li><strong>Sucursal: </strong></li>
						<li>{{ $apertura[0]['suc_desc']}}</li>
						<li><strong>Caja: </strong></li>
						<li>{{$apertura[0]['caja_descrip']}}</li>
					</ul>
				</div>
				<div class="col-sm-3">
					<ul class="list-inline">
						<li><strong>Fecha apertura: </strong></li>
						<li>{{ $apertura[0]['apert_fecha']}}</li>
						<li><strong>Hora apertura: </strong></li>
						<li>{{$apertura[0]['apert_hora']}}</li>
					</ul>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<strong>Monto cierre</strong>
						<input type="number" class="form-control" name="monto" placeholder="Monto cierre"  required>	
						</div>
				</div>
			</div>
		</div>
		<div class="card-footer">
			<button class="btn btn-success" type="submit"><span class="fa fa-save"></span> Cerrar Caja</button>
			<a href="{{route('apertura')}}" class="btn btn-secondary"><span class="fa fa-reply"></span> Atras</a>
		</div>
		</form>
	</div>
</div>

@endsection
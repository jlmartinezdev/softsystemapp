@extends('layouts.app')
@section('title','Apertura/Cierre de Caja')
@section('main')
<div id="app">
	<div class="container">
		<div class="card border-info">
			<div class="card-header bg-info text-white"><strong>Apertura - Cierre Caja</strong>
			</div>
			<div class="card-body">
				<form method="POST" action="{{route('apertura.add')}}">
					@csrf
					<input type="hidden" value="{{Auth::user()->cod_usuarios}}" name="usuario">
					<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
						<strong>Sucursal</strong>
						<select class="form-control" name="sucursal" id="selsucursal" required>
							@foreach($sucursales as $sucursal)
							 <option value="{{ $sucursal['suc_cod'] }}">{{ $sucursal['suc_desc'] }}</option>
							@endforeach
						</select>	
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
						<strong>Caja</strong>
						<select class="form-control" name="caja" required>
							@foreach($cajas as $caja)
							 <option value="{{$caja['caja_cod']}}">{{ $caja['caja_descrip'] }}</option>
							@endforeach
						</select>	
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
						<strong>Monto</strong>
						<input type="number" class="form-control" name="monto" placeholder="Monto apertura"  required>	
						</div>
					</div>
				</div>
				
				
						
			</div>
			<div class="card-footer">
				<button type="submit" class="btn btn-success font-weight-bold"><span class="fa fa-lock-open"></span> ABRIR CAJA</button>
			</div>
		</form>
		</div>
		<br>
		<table class="table table-striped table-hover table-sm">
			<tr>
				<th>Nro. Operacion</th>
				<th>Sucursal</th>
				<th>Caja</th>
				<th>Fecha</th>
				<th>Hora</th>
				<th>Estado</th>
				<th>Cerrar </th>

			</tr>
			@foreach($aperturas as $apertura)
			<tr>
				<td>{{$apertura['nro_operacion']}}</td>
				<td>{{$apertura['suc_desc']}}</td>
				<td>{{$apertura['caja_descrip']}}</td>
				<td>{{date('d/m/Y',strtotime($apertura['apert_fecha']))}}</td>
				<td>{{$apertura['apert_hora']}}</td>
				<td class="{{$apertura['apert_estado']=='1' ? 'text-danger font-weight-bold':'text-success font-weight-bold'}}">{{$apertura['apert_estado']=='1' ? 'Abierta': 'Cerrada'}}</td>
				<td>
					@if($apertura['apert_estado']=='1')
					<a href="{{ route('cierre',$apertura) }}" class="btn btn-outline-info btn-sm" title="Cerrar Caja"><span class="fa fa-lock"></span></a>
					@else
					...
					@endif
				</td>
			</tr>
			@endforeach

		</table>
	</div>
</div>
@endsection
@section('script')
<script type="text/javascript">
	function setSurcursal(){
		var obj= document.getElementById("sucursal");
		if(obj.getAttribute('data-id')!= null)
			document.getElementById("selsucursal").value= obj.getAttribute('data-id');
	}
	setSurcursal();
</script>
@endsection
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Informe de cuenta a cobrar...</title>
</head>
<body>
<table class="table table-sm">
            @foreach($ctas as $c)
                <tr >
                <!-- :class="{'mystriped': $loop->index % 2==0}" -->
                    <td>
                        <table class="table table-borderless table-sm">
                           
                            <tr class="mb-4 font-weight-bold text-primary">
                                <td><span class="fa fa-address-card text-secondary"></span> {{ $c->cliente_ruc }}</td>
                                <td colspan="2"><span class="fa fa-user text-secondary"></span> {{ $c->cliente_nombre }}</td>
                                <td colspan="2"><span class="fa fa-map-marker-alt text-secondary"></span> {{ $c->cliente_direccion}}</td>
                                <td><span class="fa fa-phone-alt text-secondary"></span> {{ $c->cliente_cel}}</td>
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
                                <td>{{ $c->nro_fact_ventas }}</td>
                                <td>{{ $c->venta_fecha }}</td>
                                <td>{{ number_format($c->total,2,",",".")}}</td>
                                <td>{{ $c->pagada ." de ". $c->cuotas  }}</td>
                                <td>{{ number_format($c->cobrado,2,",",".") }}</td>
                                <td class="text-danger font-weight-bold">{{ number_format($c->saldo,2,",",".")}}</td>
                            </tr>
                            <tr>
                                <td colspan="6" class="border-bottom"><strong>Detalle de Venta</strong>  - Descuento: {{number_format($c->venta_descuento,2,",",".")}}  </td>
                            </tr>
                            <tr>
                                <td><strong>Codigo</strong></td>
                                <td colspan="2"><strong>Descripcion</strong></td>
                                <td><strong>Cantidad</strong></td>
                                <td class="text-right"><strong>Precio</strong></td>
                                <td class="text-right"><strong>Importe</strong></td>
                            </tr>
                            @foreach( filtrarCtas($articulos,$c->nro_fact_ventas) as $dv)
                                <tr>
                                    <td>{{$dv['producto_c_barra']}}</td>
                                    <td colspan="2">{{$dv['producto_nombre']}}</td>
                                    <td>{{$dv['venta_cantidad']}}</td>
                                    <td class="text-right">{{number_format($dv['venta_precio'],2,",",".")}}</td>
                                    <td class="text-right">{{number_format($dv['venta_cantidad'] * $dv['venta_precio'],2,",",".") }}</td>
                                </tr>
                            @endforeach
                            
                        </table>  
                    </td>
                </tr>    
            @endforeach
        </table>
</body>
</html>
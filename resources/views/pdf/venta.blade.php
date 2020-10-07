<!DOCTYPE html>
<head>  
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style type="text/css">
        body{
            font-family: Arial,Helvetica, sans-serif;
        }
        .bg-gray{
            background-color: gray !important;
        }
        @media print{
            .table th{
                background-color: gray !important;       
            }
        }
    </style>
</head>
<body>

        
    <div style="font-size: 16pt; font-style: italic;">
        <center>COMPROBANTE DE VENTA</center>
    </div>
    
    <hr class="bg-primary" style="height: 4px; margin-bottom: 0px">
    <div class="row">
        <div class="col-6">
            <i>Farmacia Poharaity </i>
        </div>
        <div style="text-align: right; margin-right: 8px">
            <i>Nº Boleta:{{ str_pad($venta->nro_fact_ventas,7,"0",STR_PAD_LEFT)}}</i>
        </div>
    </div>

    <hr class="bg-primary" style="height: 3px; margin-bottom: 0px">
    <table width="100%">
        <tr>
            <td> <strong>Razon social: </strong> {{$venta->cliente_nombre}}</td>
            <td><strong>Fecha: </strong>{{$venta->venta_fecha}}</td>
        </tr>
        <tr>
            <td><strong>Documento:</strong> {{$venta->cliente_ruc}}</td>
            <td></td>
        </tr>
    </table>
   
   

    <div class="bg-primary text-white p-1">
        <center><strong><i>Detalle</i></strong></center> 
    </div>

    <div class="mt-1">
        <table class="table table-sm">
            <tr class="bg-gray text-white">
                <th>Codigo</th>
                <th>Descripcion</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Importe</th>
            </tr>
            @foreach($detalle as $d)
            <tr>
                <td>{{$d->ARTICULOS_cod}}</td>
                <td>{{$d->producto_nombre}}</td>
                <td>{{$d->venta_precio}}</td>
                <td>{{$d->venta_cantidad}}</td>
                <td>{{$d->venta_precio * $d->venta_cantidad}}</td>
            </tr>
            @endforeach
        </table> 
    </div>

</body>
</html>
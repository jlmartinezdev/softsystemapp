<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('css/OverlayScrollbars.min.css') }}" rel="stylesheet">
    <title>Generar cuota</title>
</head>
<body>
<div id="app" class="container">
<div class="row">
    <div class="col-6">
        <div class="form-group">
            <label>Monto de Venta</label>
            <p class="font-weight-bold text-primary">@{{new Intl.NumberFormat("de-DE").format(total)}}</p>
        </div>
        <div class="form-group">
            <label>Entrega</label>
            <input type="text" class="form-control number-separator" id="entrega" placeholder="Monto ..."  style="text-align:right;" @keyup="getSaldo" >
        </div>
        <div class="form-group">
            <label>Cantidad Cuota</label>
            <input type="Number" class="form-control" v-model="cant_cuota" placeholder="Cant. Cuota ...">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label>Saldo</label>
            <p class="font-weight-bold text-danger">@{{new Intl.NumberFormat("de-DE").format(saldo)}}</p>
        </div>
        
        <div class="form-group">
            <label>Interes %</label>
            <input type="number" class="form-control" v-model="interes" placeholder="Porcentaje ...">
        </div>
        <div class="form-group">
            <label><input type="checkbox"> Redondear Monto Cuota</label>
            <button @click="generar" class="btn btn-success btn-block">Generar Cuota</button>
        </div>
    </div>
</div>

    <hr> 
    <table class="table table-striped table-hover table-sm">
        <tbody>
            
        
      <template v-for="c in cuotas">
        <tr>
          <td>@{{c.nro}}</td>
          <td>@{{new Intl.NumberFormat("de-DE").format(c.monto)}}</td>
          <td>@{{c.vencimiento}}</td>
          <td>@{{c.tipo}}</td>
        </tr>
      </template>
  </tbody>
    </table>
</div>
    
</body>
<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ asset('js/jquery.overlayScrollbars.min.js') }}"></script>
<script src="{{ asset('js/adminlte.min.js') }}"></script>
<script src="{{ asset('js/separator.js')}}"></script>
<script>
var app= new Vue({
    el: '#app',
    data:{
        total: 1000000,
        cant_cuota: 3,
        sentrega: '',
        entrega: 0,
        saldo: 1000000,
        interes: 0,
        cuota: { nro: 0, interes: 0, vencimiento: 0, monto: 0, tipo: 0 },
        cuotas: [],
        redondear: true,
    },
    methods: {
        generar: function () {
            this.cuotas= [];

            let monto_cuota, Importe, cantidad, restoDivision;
            let Dia;
            let i_plus=0;
            
            Importe = this.saldo;
            cantidad = this.cant_cuota;
            
            if (cantidad < 1) {
                Swal.fire('Atención...','Cantidad de cuota es 0!','warning');
                return;
            }
            if (Importe < 1) {
                Swal.fire('Atención...','No se puede generar cuota Saldo es 0!','warning');
                return;
            }
            monto_cuota = Number.parseInt(Importe / cantidad);
            restoDivision = Importe % cantidad;
            console.log("Monto cuota:",monto_cuota);

            if (this.interes > 0) {
                monto_cuota = monto_cuota + (monto_cuota * this.interes) / 100;
            }

        
            let d = new Date();

            this._setCuota(0,this._nextMonth(d,false),this.entrega,'Entrega');  //Entrega 

            if (this.redondear && cantidad > 1 && restoDivision!=0) {

                if (monto_cuota.toString().length > 3) {
                    let ultimo_digito= monto_cuota.toString().substr(monto_cuota.toString().length-1,3);
                    let ultimos_tresdigitos= monto_cuota.toString().substr(monto_cuota.toString().length-3,3);
                    
                    if(ultimos_tresdigitos==ultimo_digito.repeat(3)){
                        let primera_cuota= monto_cuota.toString().substr(0,monto_cuota.toString().length-4);
                        primera_cuota= (Number.parseInt(primera_cuota) + 1) * 10000 
                        this._setCuota(1,this._nextMonth(d,true),primera_cuota,'Cuota');
                        cantidad--;
                        i_plus++;
                        monto_cuota= (Importe - primera_cuota)/cantidad;
                    }
                }
            }

            for (var i = 1; i <= cantidad; i++) {
                this._setCuota(i+i_plus,this._nextMonth(d,true),monto_cuota,'Cuota');
            }
        },
        _nextMonth: function(d,next){
            if(next){
                d.setMonth(d.getMonth() + 1);
            }
            return d.getDate().toString().padStart(2,'0') + '-' + (d.getMonth()+1).toString().padStart(2,'0') + '-' + d.getFullYear();
        },
        _setCuota: function(n,vencimiento,monto,tipo){
            let cuota = {
                nro: n,
                interes: this.interes,
                vencimiento: vencimiento,
                monto: monto,
                tipo: tipo,
            };
            this.cuotas.push(cuota);
        },
        showCuotas: function () {
            console.log(this.cuotas);
            console.log(this.entrega);
        },
        getSaldo: function(){
            let sentrega= $('#entrega').val();
            this.entrega= sentrega.replaceAll(',','');
            if(this.total >= this.entrega){
                this.saldo = this.total - this.entrega ;
            }else{
                Swal.fire('Atención...','Número ingresado es mayor a Monto de Venta!','warning');
                this.saldo = 0; 
            }
        }
    }
})

</script>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>

    <link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">
    <style>
      .abs-center {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
      }
    </style>
</head>
<body class="h-100">
  <div class="container" id="app">
    <div class="abs-center">
      <div class="card">
          <div class="card-header bg-info text-white">
              <strong>Iniciar Sesi&oacute;n</strong>
          </div>
        <div class="card-body">
          <div style="padding-left:10px;padding-right:10px;">
            <div id="msg" role="alert">&nbsp;</div>
            <div class="input-group">
              <span class="input-group-prepend">
                <span class="input-group-text">
                  <span class="fa fa-user"></span>
                </span>
              </span>
              <select v-model="usuario" class="custom-select">
                <option>Seleccionar</option>
                <template v-for="usuario in usuarios">
                  <option v-bind:value="usuario.user_usuarios">
                  @{{ usuario.nom_usuarios }}
                  </option>
                </template>
              </select>
            </div>
            <br>
            <div class="input-group">
              <span class="input-group-prepend">
                <span class="input-group-text">
                  <span class="fa fa-key"></span>  
                </span>
              </span>
              <input tabindex="2" v-on:keyup.enter="enviar()"  type="password" v-model="password" class="form-control" placeholder="Contraseña">
            </div>      
          </div>
        </div>
        <div class="card-footer">
            <center><button v-on:click="enviar()" class="btn btn-success" ><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;Acceder al Sistema</button></center>
            <span class="text-muted align-items-center">Sistema de Gestion de Stock, Compra, Venta &copy; 2020</span>   
        </div>
      </div>
    </div>
    
  </div>
</body>
<script src="{{ mix('js/app.js') }}"></script>
<script>
    //const axios = require('axios').default;
    var app = new Vue({
  el: '#app',
  data: {
    usuario:'Seleccionar',
    usuarios:[],
    password:'',
    error:''
  },
  methods: {
    getUser:function(){
      var url='{{route("showalluser")}}';
      axios.get(url)
      .then(response=>{
        this.usuarios= response.data;
      })
      .catch(e=>{
        this.error= e.message;
      })
    },
    enviar: function () {
        var url='/login';
        if(this.usuario.length>0 && this.password.length>0){
            axios.post(url,{
                user_usuarios: this.usuario.trim(),
                password: this.password
            })
            .then(response=>{
                if(response.data.success=="no"){                    
                    Swal.fire(
                      'Error!',
                      'Contraseña incorrecta...',
                      'error'
                    )
                }else{
                    window.location.href="{{route('home')}}";
                }
            })
            .catch(e=>{
                this.error= e.message;
            });
        }else{
             Swal.fire(
              'Atencion!',
              'Complete los campos!',
              'warning'
            )
        }
    }
  },
  mounted(){
    this.getUser();
  }
})
</script>
</html>
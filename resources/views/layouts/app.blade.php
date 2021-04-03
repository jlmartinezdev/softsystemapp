<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield("title")</title>
    

    <!-- Scripts -->

      <!-- Styles -->
    <link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('css/OverlayScrollbars.min.css') }}" rel="stylesheet">
    @yield("style")
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @guest
            @include('partial.sidebar_login')
        @else
             @include('partial.sidebar_top')
            @if(Auth::user()->cod_rol == 4)
                @include('partial.sidebar_administrador')
            @else
                @include('partial.sidebar_vendedor')
            @endif
        @endguest
        <br>
         <div class="content-wrapper">
            <section class="content">
            <div class="container-fluid">
            @yield('main')
            </div>
            </section>
        </div>
        <footer class="main-footer">
        @yield('footer')
        </footer>
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('js/adminlte.min.js') }}"></script>
    <script type="text/javascript">
        function soloNumero(event)
        {
            if(event.charCode >= 48 && event.charCode <= 57)
            { 
              return true;
            }
            return false; 
        }
        function format(input)
        {
            var num = input.value.replace(/\./g,"");
            num = num.toString().split("").reverse().join("").replace(/(?=\d*\.?)(\d{3})/g,'$1.');
            num = num.split("").reverse().join("").replace(/^[\.]/, "");
            input.value = num;   
        }
        function getSucursal(){
            var id= localStorage.getItem("suc_cod");
            var desc= localStorage.getItem("suc_desc");
            if(desc != null){
                var obj= document.getElementById("sucursal");
                obj.setAttribute('data-id',id);
                obj.innerHTML=" "+desc
            }else{
                var obj= document.getElementById("sucursal");
                obj.innerHTML=" Sel. Sucursal"
            }
            
        }
         
            @auth 
                getSucursal();
            @endauth
    
        
    
    
    </script>
    @yield('script')
</body>
</html>
 
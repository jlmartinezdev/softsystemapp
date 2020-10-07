 <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm fixed-top">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'SOFTSYSTEM') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <!-- Authentication Links -->
                        <li>
                            <a class="nav-link {{ setActive('home')}}" href="{{ route('home') }}"><span class="fa fa-home"></span> Inicio <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="submenu_man" role="button" data-toggle="dropdown" aria-haspopup=true aria-expanded="false">Mantenimiento</a>
                            <div class="dropdown-menu" aria-labelledby="submenu_man" >
                                <a href="{{route('seccion.index')}}" class="dropdown-item">Seccion</a>
                                <a href="{{route('cliente.index')}}" class="dropdown-item"> Cliente</a>
                            </div>
                        </li>
                            <li class="nav-item">
                                <a class="nav-link  {{ setActive('venta')}}" href="{{ route('venta') }}"><span class="fa fa-cog"></span> Venta</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="submenu_man" role="button" data-toggle="dropdown" aria-haspopup=true aria-expanded="false"><span class="fa fa-cash-register"></span> Caja</a>
                                <div class="dropdown-menu" aria-labelledby="submenu_man" >
                                    <a href="{{ route('apertura') }}" class="dropdown-item">Apertura - Cierre</a>
                                    <div class="dropdown-divider"></div>
                                    <a href="{{ route('movimiento') }}" class="dropdown-item">Movimiento Caja</a>
                                    
                                </div>
                            </li>                           
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                  <span class="fa fa-user"></span>  {{ Auth::user()->nom_usuarios }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Cerrar Sesion') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a href="{{route('sucursal.set')}}" class="nav-link"><span class="fa fa-warehouse"></span><span id="sucursal"></span></a>
                               
                            </li>
                    </ul>
                </div>
            </div>
        </nav>
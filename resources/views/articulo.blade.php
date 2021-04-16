@extends('layouts.app')
@section('title','Articulo')
@section('main')
<div class="container" id="app">
    <div class="font-weight-bold" style="font-size: 14pt;">Mantimiento de Articulos</div>
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-4 col-md-2 p-2">
              <button class="btn btn-primary" @click="showMArticulo"><span class="fa fa-plus"></span> Nuevo</button>
            </div>
            <div class="col-sm-8 col-md-6">
              <div class="input-group">
                <input type="text" v-model="txtbuscar" @keyup.enter="buscar(false)" class="form-control" placeholder="Buscar...."/>
                <div class="input-group-append">
                  <button class="btn btn-secondary" @click="buscar(false)">
                    <template v-if="requestSend">
                        <span class="spinner-border spinner-border-sm" role="status"></span><span class="sr-only">Buscando...</span> Cargando...
                    </template>
                    <template v-else>
                       <span class="fa fa-search"></span> Buscar
                    </template>
                    </button>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <registro_mostrado :pagina_actual="paginacion.pagina_actual" :desde="paginacion.desde" :hasta="paginacion.hasta" :total="paginacion.total">
            </registro_mostrado>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2">
              <label><strong>Seccion</strong></label>
              <select class="form-control form-control-sm" v-model="filtro.seccion">
                <option value="0">Todos</option>
                @foreach($secciones as $seccion)
                  <option value="{{$seccion['present_cod']}}">{{ $seccion['present_descripcion']}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-2">
              <label><strong>Ordenar Por</strong></label>
              <select class="form-control form-control-sm" v-model="filtro.columna">
                <option value="0">Descripcion</option>
                <option value="1">Codigo</option>
                <option value="2">Precio</option>
              </select>
            </div>
            <div class="col-md-2">
              <div class="d-flex" style="margin-top:28pt;">

                <div class="custom-control custom-radio">
                  <input type="radio" id="asc" name="radio" value="ASC" class="custom-control-input" v-model="filtro.orden">
                  <label class="custom-control-label" for="asc">Asc&nbsp;<span class="fa fa-sort-alpha-down"></span></label>
                </div>
                <div class="custom-control custom-radio ml-2">
                  <input type="radio" id="desc" name="radio" value="DESC" class="custom-control-input" v-model="filtro.orden">
                  <label class="custom-control-label" for="desc">Desc&nbsp;<span class="fa fa-sort-alpha-up"></span></label>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <nav style="margin-top:25pt;">
                <v-pagination v-model="currentPage"
                  :page-count="paginacion.ultima_pagina"
                  :classes="bootstrapPaginationClasses"
                  :labels="customLabels"
                  @change="onChange">
                </v-pagination>
              </nav>
            </div>
              
          </div>
        </div>
        
      </div><!--  END CARD -->

		<template>
      <div class="table-responsive-sm">
        <table id="tabla" class="table table-striped table-hover table-sm">
        <thead>
        <tr class="text-uppercase">
          <th>Codigo</th>
          <th>Descripcion</th>
          <th>Seccion</th>
          <th class="text-right">Precio</th>
          <th>Stock</th>
          <th>Acciones</th>
        </tr>
        </thead>
        <tbody style="font-family: Arial,Helvetica,sans-serif;">
          <template v-for="a in articulos">
            <tr :class="{'text-danger': a.cantidad==0}">
              <td>@{{ a.producto_c_barra }}</td>
              <td>@{{ a.producto_nombre }}</td>
              <td>@{{ a.present_descripcion }}</td>
              <td class="font-weight-bold text-right">@{{ separador(a.pre_venta1) }}</td>
              <td class="text-center font-weight-bold">@{{ a.cantidad }}</td>
              <td>
                <div class="btn-group btn-group-sm">
                    <button class='btn btn-outline-primary' data-toggle="tooltip" @click="showEArticulo(a)" data-placement="top" style="width: 28pt;" title="Editar"><span class="fa fa-edit"></span></button>
                    <button class='btn btn-outline-danger' data-toggle="tooltip" data-placement="top" @click="modalDelete(a.ARTICULOS_cod,a.producto_nombre)" style="width: 28pt;" title="Eliminar"><span class="fa fa-trash"></span></button>
                    <button class='btn btn-outline-warning' data-toggle="tooltip" @click="showDetalle(a.ARTICULOS_cod,a.producto_nombre)" data-placement="top"  style="width: 28pt;" title="Transferir"><span class="fa fa-retweet"></span></button>
                </div>
                
              </td>
            </tr>
          </template>
        </tbody>
      </table>
      </div>
			
      
      <!--div class="d-flex flex-column">
                  <span>{ a.producto_nombre }}</span>
                  <span class="text-muted small">{ a.present_descripcion }}</span>
                </div -->
		</template>

@include("articulo.create")
@include("articulo.edit")
@include("articulo.delete")
@include("articulo.detalle")

</div>
@endsection
@section('script')
<script>


var app = new Vue({
  el: '#app',
  data: {
    requestSend:false,
    currentPage: 1,
    bootstrapPaginationClasses: { 
      ul: 'pagination',
      li: 'page-item',
      liActive: 'active',
      liDisable: 'disabled',
      button: 'page-link'
    },
    customLabels: {
      first: 'Primer',
      prev: 'Ant',
      next: 'Sig',
      last: 'Ultimo'
    },
    paginacion: {
      'total': 0,
      'pagina_actual': 1,
      'por_pagina': 0,
      'ultima_pagina': 0,
      'desde': 0,
      'hasta': 0
    },
  	url:'controller/ArticulosController.php',
  	reservarC: false,
  	bandstock: 0,
  	txtbuscar:'',
  	datos: 'F',
  	idstock: 1,
   	articulos:[],
   	secciones:[],
   	sucursales: [],
   	unidades:[],
    filtro: {seccion: 0, columna: 0, orden: 'ASC'},
   	articulo:{codigo:'','c_barra':'','descripcion':'','indicaciones':'','modouso':'','seccion':1,'unidad':1,'factor':1,'ubicacion':'','costo':0,'p1':0,'p2':0,'p3':0,'p4':0,'p5':0,'m1':0,'m2':0,'m3':0,'m4':0,'m5':0,'svenc':'0'},
   	stock: {'id':0,'cantidad':0,'loteold':'','lotenew':'','vencimiento':'','sucursal':1},
   	stocks:[],
   	error: '',
    cantidadStock :0,
    frmt:{i: -1,t:false,suc:0,cant:0}
  },
  methods: {
    validar_Cbarra: function(){
      if(this.articulo.c_barra.length==0){
        this.articulo.c_barra= this.articulo.codigo.toString().padStart(7,'0')
      }
    },
    onChange: function () {//Al cambiar pagina
      if(this.paginacion.ultima_pagina > 1){
         this.buscar(true);
      }
     
    },
    color: function(id){
      return this.frmt.i==id ? true : false;
    },
    cancelTrans: function(){
      $('#accordiontransferir').collapse('hide');
      this.frmt={i: -1,t:false,suc:0,cant:0}
    },
  	buscar: function(isPaginate){
        this.requestSend= true;
        let pag= isPaginate? this.currentPage: 1
  			axios.get('articulo/buscar',{
          params:{page:pag,buscar:this.txtbuscar,criterio:0,seccion:this.filtro.seccion,col:this.filtro.columna,ord:this.filtro.orden,suc:null}
        })
	  		.then(response=>{
          this.requestSend= false;
          if(response.data=='NO'){
            Swal.fire('No se encontrado resultado!','Para:  '+this.txtbuscar, 'info' );
          }else{
            this.articulos= response.data.articulos.data;
            this.paginacion= response.data.paginacion;
            //this.paginacion.pagina_actual=1;
            this.currentPage= 1;
          }
	  			//this.error=response.data;
	  		})
	  		.catch(e=>{
          this.requestSend= false;
	  			this.error= e.message;
	  		});
  	},
  	setUtilPrecio: function(tipo,i){
  		if(tipo=='M'){
  			this.articulo['p'+i]= ((this.articulo.costo * this.articulo['m'+i])/100) + parseFloat(this.articulo.costo);
  		}else{
  			if(this.articulo.costo >0 && this.articulo['p'+i]  > 0){
  				var res= this.articulo['p'+i] - this.articulo.costo;
  				this.articulo['m'+i]= Math.round(res*100/this.articulo.costo);
  			}
  		}
  	},
  	separador: function(number){
  		var n=parseFloat(number);
  		return new Intl.NumberFormat().format(n);
  	},
  	showMArticulo: function(){
  		$('#addArticulo').modal('show');
  		this.getUltimo();
  		$('input[name="cbarra"]').focus();
  	},
  	showEArticulo: function(a){
  		$('#editArticulo').modal('show');
  		this.articulo= {'codigo':a.ARTICULOS_cod,'c_barra': a.producto_c_barra,'descripcion':a.producto_nombre,'indicaciones':a.producto_indicaciones==null? a.producto_indicaciones: a.producto_indicaciones/*.trim()*/,'modouso':a.producto_dosis==null? a.producto_dosis : a.producto_dosis/*.trim()*/,'seccion':a.present_cod,'unidad':a.uni_codigo,'factor':a.producto_factor,'ubicacion':a.producto_ubicacion,'costo':a.producto_costo_compra,'p1':a.pre_venta1,'p2':a.pre_venta2,'p3':a.pre_venta3,'p4':a.pre_venta4,'m1':parseInt(a.pre_margen1,10),'m2':parseInt(a.pre_margen2,10),'m3':parseInt(a.pre_margen3,10),'m4':parseInt(a.pre_margen4,10),'svenc':'0'}
  		this.getStock(a.ARTICULOS_cod);
  		this.reservarC= false;
  	},
  	setPrecioVenta: function(){
  		if(this.articulo.costo>0){
  			for (var i = 1; i < 5; i++) {
  				this.articulo['p'+i]= ((this.articulo.costo * this.articulo['m'+i])/100) + parseFloat(this.articulo.costo);
				
  			}
  		}
  	},
  	getD: function(){
  		return {'id':this.idstock,'cantidad':this.stock.cantidad,'loteold': this.reservarC ?this.stock.lotenew : this.stock.loteold,'lotenew':this.stock.lotenew ,'vencimiento':this.validarVenc(this.stock.vencimiento),'sucursal':this.stock.sucursal};
  	},
  	validarVenc: function(fecha){
  		if(fecha.length<1){
  			return "Sin vencimiento";
  		}
  		this.articulo.svenc= '1' 
  		return fecha;
  	},
  	addStock: function(){
  			if(this.stock.cantidad > 0){
          var x =this.stocks.findIndex(x=> x.lotenew==this.stock.lotenew && x.sucursal== this.stock.sucursal);
          if(x == -1){
            this.idstock= this.stocks.length+1;
            this.stock.loteold=this.stock.lotenew;
            this.stocks.push(this.getD());

            this.limpiarCamposStock();
          }else{
              const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true
              })
              Toast.fire({
                icon: 'success',
                title: 'Existe un lote igual a esta, se actualiza cantidad...'
              })
            this.stocks[x].cantidad =parseInt(this.stocks[x].cantidad) + parseInt(this.stock.cantidad);
            if(this.stock.vencimiento.length > 0){
              this.stocks[x].vencimiento= this.stock.vencimiento;
            }
          }
	  		}
  	},
    setStock: function(s,index){
     
      if(this.frmt.t){
        this.frmt.i= -1;  
        this.frmt.t= false;
      }else{
          this.frmt.t= true;  
        this.frmt.i= index;
      }
      this.stock= {'id':s.id,'cantidad':0,'loteold': s.loteold,'lotenew':s.lotenew ,'vencimiento':s.vencimiento,'sucursal':s.sucursal};
    },
    transladarStock: function(){
      const i= this.stocks.findIndex(stock =>stock.id== this.stock.id);
      
      if(this.frmt.cant > 0 && this.frmt.suc>0){
        if(this.stocks[i].sucursal==this.frmt.suc){
          Swal.fire('Atencion!','Seleccione otra sucursal!','warning');
          return false;
        }
        if(this.frmt.cant> this.stocks[i].cantidad){
          Swal.fire('Atencion!','Cantidad ingresada es Mayor!','warning');
          return false;
        }
        this.stocks[i].cantidad= parseInt(this.stocks[i].cantidad) -this.frmt.cant;
        this.stocks.push({'id':this.stocks.length+1,'cantidad':this.frmt.cant,'loteold': this.stock.loteold,'lotenew':this.stock.lotenew ,'vencimiento':this.stock.vencimiento,'sucursal':this.frmt.suc});
        this.updateStock();
        
      }else{
        Swal.fire('Atencion!','Seleccione Destino e ingrese cantidad!', 'error' );
      }
    },
  	getByIdSucursal: function (id){
  		const suc= this.sucursales.find(sucursal => sucursal.suc_cod==id);
  		return suc.suc_desc;
  	},
  	limpiarCamposStock: function(){
  		this.bandstock=0;
  		this.stock= {'id':0,'cantidad':0,'loteold':'','lotenew':'','vencimiento':'','sucursal':1};
  	},
  	vaciarTodos:  function(){
  		this.stocks=[];
      this.limpiarCamposStock();
  		this.articulo= {'codigo':'','c_barra':'','descripcion':'','indicaciones':'','modouso':'','seccion':1,'unidad':1,'factor':1,'ubicacion':'','costo':0,'p1':0,'p2':0,'p3':0,'p4':0,'m1':0,'m2':0,'m3':0,'m4':0,'svenc':'0'};
  	},
  	delStockA: function(id){
  		const s= this.stocks.find(stock =>stock.id== id);
      if(s.id>20){
        const cant= parseInt(s.cantidad);
        var index= this.articulos.findIndex(x=> x.ARTICULOS_cod== this.articulo.codigo);
        this.articulos[index].cantidad= parseInt(this.articulos[index].cantidad) - cant;
        if(!this.reservarC){
          axios.delete('stock/'+s.id)
          .then(response=>{
            console.log(response.data)
          })
          .catch(e=>{
            console.log(e.message);
          });
        }
      }
      this.stocks.pop(s);
      this.limpiarCamposStock();
  	},
  	editStockA: function(stock){
  		this.stock= stock;
  		this.bandstock=1;
  	},
    modalDelete: function(id,descripcion){
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
          axios.delete(this.url,{data:{articulocod: id}})
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
    showDetalle: function(id,desc){
      this.articulo.descripcion= desc;
      this.articulo.codigo=id;
      this.getStock(id);
      $('#detalleArticulo').modal('show');
    },
  	delArticulo: function(){
  		if(this.reservarC){
  			this.reservarC= false;
  			axios.delete('articulo/res/'+this.articulo.codigo)
  			.then(response=>{
  				console.log(response.data)
  			})
  			.catch(e=>{
  				console.log(e.message);
  			});
  		}
  	},
    updateStock(){
      if(this.stocks.length>0){
        axios.post('stock/'+this.articulo.codigo,{
          stock: this.stocks
        }).then(r=>{
          this.cancelTrans();
          this.buscar();
        }).catch(e=>{
          this.error= e.message;
        })
      }
    },
  	saveArticulo: function(){
  		if(this.articulo.descripcion && this.articulo.costo && this.articulo.p1){
  			this.error="";
  			if(this.stocks.length>0){
  				axios.put('articulo/'+this.articulo.codigo,{
  					articulo: this.articulo,
  					stock: this.stocks
  				})
  				.then(r=>{
  					
  					this.vaciarTodos();
  					this.reservarC ? $('#addArticulo').modal('hide'): $('#editArticulo').modal('hide');
            this.buscar();
  					this.reservarC=false;
  				})
  				.catch(e=>{
  					this.error= e.message;
  				})
  			}else{
          Swal.fire('Atencion','Falta agregar Stock!','warning');
  			}
  		}else{
        Swal.fire('Atencion','Hay campos obligatorios (*) vacios!','warning');
  		}
  	},
    getArticulo:function(){
      axios.get('articulo/buscar')
      .then(response=>{
        this.articulos= response.data.articulos.data;
        this.datos= 'T';
      })
      .catch(e=>{
        this.error= e.message;
      })
    },
    getStock:function(id){
    axios.get('stock/'+id).then(r=>{this.stocks= r.data;}).catch(e=>{this.error= e.message;})	
    },
    reservarCodigo: function(){
      axios.post('articulo/res',{"codigo":this.articulo.codigo})
      .then(r=>{this.reservarC=true;})
      .catch(e=>{this.error= e.message;})
    },
    getUltimo: function(){
      axios.get('articulo/ultimo').then(r=>{
        this.articulo.codigo= (r.data)+1;
        this.reservarCodigo();
      }).catch(e=>{Console.log(e.message)})
    },
    getSeccion: function(){
    	var url='seccion/all';
		axios.get(url)
		.then(response=>{
		this.secciones= response.data;
		})
		.catch(e=>{
		this.error= e.message;
		})
    },
    getUnidad: function(){
    	var url='unidad/all';
		axios.get(url)
		.then(response=>{
		this.unidades= response.data;
		})
		.catch(e=>{
		this.error= e.message;
		})
    },
    getSucursal: function(){
    	var url='sucursal/all';
		axios.get(url)
		.then(response=>{
		this.sucursales= response.data;
		})
		.catch(e=>{
		this.error= e.message;
		})
    }
   },
  computed:{
    totalStock(){
      this.cantidadStock=0;
      for(i=0;i<this.stocks.length;i++){
        this.cantidadStock +=parseInt(this.stocks[i].cantidad);
      }
      return this.cantidadStock;
    }
  },
  mounted(){
     this.buscar();
     this.getSucursal();
    }
})
$('#addArticulo').on('hidden.bs.modal',function(e){
	app.delArticulo();
});
$('#editArticulo').on('hidden.bs.modal',function(e){
	app.vaciarTodos();
});

</script>

@endsection
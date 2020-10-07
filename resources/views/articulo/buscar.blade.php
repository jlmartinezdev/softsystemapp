<!-- PASAR A TEMPLATE -->
<div class="modal fade" id="busquedaArticulo">
	<div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header bg-dark text-white">
				<h4 class="modal-title">Buscar Articulo...</h4>
				<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Cerrar</span>
				</button>
			</div>
			<div class="modal-body">
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
	           
                <table class="table table-sm table-striped table-hover mt-2">
                	<tr>
                		<th>Codigo</th>
                		<th>Descripcion</th>
                		<th>Precio</th>
                		<th>Stock</th>
                		<th>Acciones</th>
                	</tr>
                	<template v-for="articulo in articulos">
                		<tr :class="{'text-danger': articulo.cantidad==0}">
                			<td>@{{articulo.producto_c_barra}}</td>
                			<td>@{{articulo.producto_nombre}}</td>
                			<td><strong>@{{new Intl.NumberFormat("de-DE").format(articulo.pre_venta1)}}</strong></td>
                			<td><strong>@{{articulo.cantidad}}</strong></td>
                			<td>
                				<button class="btn btn-outline-primary btn-sm" @click="validarArticulo(articulo)" title="Seleccionar">
                					<span class="fa fa-cart-plus"></span>
                				</button>
                			</td> 
                		</tr>
                	</template>
                </table>

			</div>
			<div class="modal-footer">
				<template v-if="requestLote">
					<div class="mr-5 text-info">
						<span class="spinner-border spinner-border-sm" role="status"></span><span class="sr-only">Validando...</span> Verificando lotes...
					</div>
				</template>
				 <v-pagination v-model="currentPage"
                  :page-count="paginacion.ultima_pagina"
                  :classes="bootstrapPaginationClasses"
                  :labels="customLabels"
                  @change="onChange">
                </v-pagination>
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><span class="fa fa-times"></span> Cerrar</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
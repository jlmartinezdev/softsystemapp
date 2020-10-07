<!-- PASAR A TEMPLATE -->
<div class="modal fade" id="busquedaCliente">
	<div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Buscar Cliente...</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Cerrar</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="input-group">
	                <input type="text" v-model="txtcliente" @keyup.enter="buscarCliente()" class="form-control" placeholder="Buscar por nombre o C.I. ...."/>
	                <div class="input-group-append">
	                  <button class="btn btn-secondary" @click="buscarCliente()">
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
                		<th>Documento</th>
                		<th>Nombre y Apellido</th>
                		<th>Direccion</th>
                		<th>Celular</th>
                		<th>Sel.</th>
                	</tr>
                	<template v-for="cliente in clientes">
                		<tr>
                			<td>@{{cliente.cliente_ci}}</td>
                			<td>@{{cliente.cliente_nombre}}</td>
                			<td>@{{cliente.cliente_direccion}}</td>
                			<td>@{{cliente.cliente_cel}}</td>
                			<td>
                				<button class="btn btn-outline-primary btn-sm" @click="selectCliente(cliente.clientes_cod,cliente.cliente_nombre)" title="Seleccionar">
                					<span class="fa fa-user-check"></span>
                				</button>
                			</td>
                		</tr>
                	</template>
                </table>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><span class="fa fa-times"></span> Cerrar</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
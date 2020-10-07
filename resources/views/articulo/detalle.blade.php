<div class="modal fade" id="detalleArticulo">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header bg-dark text-white">
				<h4 class="modal-title">Detalle Articulo</h4>
				<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
			</div>
			<div class="modal-body">
				<span class="m-3">Articulo:<strong> [@{{articulo.descripcion}}]</strong></span>
				<table class="table table-striped table-sm">
					<tr>
						<th>Sucursal</th>
						<th>Stock</th>
						<th>Lote</th>
						<th>Vencimiento</th>
						<th>Transferir</th>
					</tr>
					<template v-if="stocks">
						<template v-for="(stock,index) in stocks">
							<tr :class="{'bg-info text-white' : color(index)}">
								<td>@{{getByIdSucursal(stock.sucursal)}}</td>
								<td>@{{stock.cantidad}}</td>
								<td>@{{stock.lotenew}}</td>
								<td>@{{stock.vencimiento}}</td>
								<td>
									<button class="btn btn-outline-warning btn-sm" data-toggle="collapse" data-target="#accordiontransferir" @click="setStock(stock,index)" aria-expanded="false"><span class="fa fa-cog"></span></button>
								</td>
							</tr>
						</template>
						<tr>
							<td colspan="5">Total Stock: @{{totalStock}}</td>
						</tr>
					</template>
				</table>
				<div class="collapse" id="accordiontransferir">
					<div class="card card-outline-primary border-info p-3">
						<div class="row">
							<div class="form-group col">
								<label><strong>Destino: </strong></label>
								<select class="custom-select custom-select-sm" v-model.number="frmt.suc">
									<option value="0" >Seccionar</option>
									<template v-for="sucursal in sucursales">
						      			<option :value="sucursal.suc_cod">@{{ sucursal.suc_desc.trim() }}</option>
						      		</template>
								</select>
							</div>
							<div class="form-group col">
								<label><strong>Cantidad</strong></label>
								<input type="number" v-model.number="frmt.cant" class="form-control form-control-sm" placeholder="Cantidad a Transferir">
							</div>	
							<div class="form-group col pt-4">
								<button class="btn btn-success btn-sm" @click="transladarStock"><span class="fa fa-check"></span> OK</button>
								<button class="btn btn-secondary btn-sm" @click="cancelTrans"><span class="fa fa-times"></span> Cancelar</button>	
							</div>
							
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><span class="fa fa-times"></span> Cerrar</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
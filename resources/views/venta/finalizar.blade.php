<div class="modal fade" id="finalizarventa">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Confirmar Venta...</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Cerrar</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row m-auto">
					<div class="col-sm-4">
						<div class="form-group">
							Forma de Pago
							<select class="form-control form-control-sm" v-model="ventaCabecera.formacobro">
								<option value="1">Efectivo</option>
								<option value="2">Tarjeta</option>
							</select>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							Condicion de Venta
							<select class="form-control form-control-sm" v-model="ventaCabecera.condicionventa">
								<option value="1">Contado</option>
								<option value="2">Credito</option>
							</select>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="pt-4">
							<button class="btn btn-primary btn-sm"><span class="fa fa-cog"></span> Generar Cuota</button>
						</div>
					</div>
				</div>
				<hr>
				<div class="text-center">
					<p class="text-muted">Total a Pagar</p>
					<h2>@{{totalVenta}}</h2>
					<p>@{{ numeroaletra(ventaCabecera.total) }}</p>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-success" @click="finalizar"><span class="fa fa-check"></span> CONFIRMAR VENTA</button>
				<button class="btn btn-secondary" data-dismiss="modal"><span class="fa fa-reply"></span> CANCELAR</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="finalizarventa">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Confirmar Venta...</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Cerrar</span>
				</button>
			</div>
			<div class="modal-body">
				<nav>
					<div class="nav nav-tabs" role="tablist">
						<a class="nav-item nav-link active"  data-toggle="tab" href="#fin" role="tab" aria-controls="fin" aria-select="true">Finalizar</a>
						<a class="nav-item nav-link" :class="{ disabled: ventaCabecera.condicionventa=='1' }" data-toggle="tab" href="#generar" role="tab" aria-controls="generar" aria-select="false">Generar Cuota</a>
					</div>
				</nav>
				
				<div class="tab-content">
					<div class="tab-pane fade active show" id="fin" role="tabpanel">
						<div class="row m-2">
							<div class="col-sm-6">
								<div class="form-group">
									Forma de Pago
									<select class="form-control form-control-sm" @change="saveDatos" v-model="ventaCabecera.formacobro">
										<option value="1">Efectivo</option>
										<option value="2">Tarjeta</option>
									</select>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									Condicion de Venta
									<select class="form-control form-control-sm" @change="saveDatos" v-model="ventaCabecera.condicionventa">
										<option value="1">Contado</option>
										<option value="2">Credito</option>
									</select>
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
					<div class="tab-pane fade" id="generar" role="tabpanel">
					
						<generar_cuota :total="ventaCabecera.total"/>

					</div>
				</div>

				
			</div>
			<div class="modal-footer">
				<button class="btn btn-success" @click="finalizar"><span class="fa fa-check"></span> CONFIRMAR VENTA</button>
				<button class="btn btn-secondary" data-dismiss="modal"><span class="fa fa-reply"></span> CANCELAR</button>
			</div>
		</div>
	</div>
</div>
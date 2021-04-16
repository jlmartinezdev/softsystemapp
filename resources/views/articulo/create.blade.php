<div class="modal fade" id="addArticulo">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header bg-warning">
		        <h5 class="modal-title">Nuevo Articulo</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
			<div class="modal-body">
				<nav>
					<div class="nav nav-tabs" role="tablist">
						<a class="nav-item nav-link active" data-toggle="tab" role="tab" href="#frmdescrip" aria-controls="frmdescrip" aria-select="true">Descripcion</a>
						<a class="nav-item nav-link" data-toggle="tab" role="tab" href="#frmstock" aria-controls="frmstock" aria-select="false">Stock</a>
						<a class="nav-item nav-link" data-toggle="tab" role="tab" href="#frmprecio" aria-controls="frmprecio" aria-select="false">Precio</a>
					</div>
				</nav> 
				<div class="tab-content">
					<div class="tab-pane fade show active" id="frmdescrip" role="tabpanel">
						<div class="form-row">
	    					<div class="col">
	    						<div class="form-group">
							      <strong><label for="codigo">Codigo</label></strong>
							      <input type="text" v-model="articulo.codigo" class="form-control form-control-sm" disabled name="codigo" placeholder="Auto">
							    </div>
							</div>
							<div class="col">
								<div class="form-group">
							      <strong><label for="cbarra">Codigo de Barra</label></strong>
							      <input type="text" v-model="articulo.c_barra" @blur="validar_Cbarra" class="form-control form-control-sm" name="cbarra" placeholder="Codigo de Barra">
							    </div>
							</div>
						</div>
						<div class="form-row">
	    					<div class="col">
	    						<div class="form-group">
							      <strong><label for="descripcion">Descripcion *</label></strong>
							      <input type="text" v-model="articulo.descripcion" class="form-control form-control-sm" name="descripcion" placeholder="Descripcion de Articulo">
							    </div>
							</div>
	    					<div class="col">
	    						<div class="form-group">
							      <strong><label for="indicaciones">Indicaciones</label></strong>
							      <input type="text" v-model="articulo.indicaciones" class="form-control form-control-sm" name="indicaciones" placeholder="Indicaciones">
							    </div>
	    					</div>
						</div>
						<div class="form-row">
	    					<div class="col">
	    						<div class="form-group">
							      <strong><label for="modouso">Modo de Uso</label></strong>
							      <input type="text" v-model="articulo.modouso" class="form-control form-control-sm" name="modouso" placeholder="Modo de Uso">
							    </div>
							</div>
						</div>
						<div class="form-row">
	    					<div class="col">
	    						<div class="form-group">
							      <strong><label for="seccion">Seccion *</label></strong>
							      <select name="seccion" v-model="articulo.seccion" class="form-control form-control-sm">
							      	<option value="0">Seleccionar</option>
							      	@foreach($secciones as $seccion)
							      		<option value="{{$seccion['present_cod']}}"> {{ $seccion['present_descripcion'] }}</option>
							      	@endforeach
							      </select>
							    </div>
							</div>
							<div class="col">
								<div class="form-group">
							      <strong><label for="unidad">Unidad *</label></strong>
							      <select name="unidad" v-model="articulo.unidad" class="form-control form-control-sm">
							      	<option value="0">Seleccionar</option>
							      	@foreach($unidades as $unidad)
							      		<option value="{{$unidad['uni_codigo']}}">{{ $unidad['uni_nombre'] }}</option>
							      	@endforeach
							      </select>
							    </div>
							</div>
							<div class="col">
								<div class="form-group">
							      <strong><label for="factor">Factor</label></strong>
							      <input type="text" v-model="articulo.factor" class="form-control form-control-sm" name="factor" placeholder="Factor">
							    </div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="frmstock" role="tabpanel">
						<div class="form-row">
	    					<div class="col">
	    						<div class="form-group">
							      <strong><label for="stock">Stock *</label></strong>
							      <input type="number" onfocus="this.select()" v-model.number="stock.cantidad" class="form-control form-control-sm" name="stock" placeholder="Stock">
							    </div>
							</div>
							<div class="col">
								<div class="form-group">
							      <strong><label for="lote">Lote</label></strong>
							      <input type="text" v-model="stock.lotenew" class="form-control form-control-sm" name="lote" placeholder="Lote">
							    </div>
							</div>
							<div class="col">
								<div class="form-group">
							      <strong><label for="vencimiento">Vencimiento</label></strong>
							      <input type="date" v-model="stock.vencimiento" class="form-control form-control-sm" name="vencimiento" placeholder="Vencimiento">
							    </div>
							</div>
							<div class="col">
								<div class="form-group">
							      <strong><label for="sucursal">Sucursal</label></strong>
							      <select v-model="stock.sucursal" class="form-control form-control-sm">
							      	<option value="0">Seleccionar</option>
							      	<template v-for="sucursal in sucursales">
							      		<option :value="sucursal.suc_cod">@{{ sucursal.suc_desc }}</option>
							      	</template>
							      </select>
							    </div>
							</div>
						</div>
						<div class="form-row">
							<div class="col">
								<template v-if="bandstock==0">
									<button class="btn btn-outline-info" v-on:click="addStock()"><span class="fa fa-plus"></span> Agregar</button>
								</template>
								<template v-else>
									<button class="btn btn-outline-info" v-on:click="limpiarCamposStock()"><span class="fa fa-save"></span> Listo</button>
								</template>
								
							</div>
							<div class="col">
								<strong><label>Ubicacion</label></strong>								
							    <input type="text" v-model="articulo.ubicacion" class="form-control form-control-sm" name="ubicacion" placeholder="Ubicacion">
							</div>
						</div>
						<div class="form-row py-3">
							<table class="table table-sm table-striped table-bordered table-hover">
								<tr>
									<th>Sucursal</th>
									<th>Stock</th>
									<th>Lote</th>
									<th>Vencimiento</th>
									<th>Acciones</th>
								</tr>
								<template v-if="stocks">
									<template v-for="stock in stocks">
										<tr>
											<td>@{{getByIdSucursal(stock.sucursal)}}</td>
											<td>@{{stock.cantidad}}</td>
											<td>@{{stock.lotenew}}</td>
											<td>@{{stock.vencimiento}}</td>
											<td>
												<button v-on:click="editStockA(stock)" class="btn btn-outline-info btn-sm"><span class="fa fa-edit"></span> Modificar</button>
										<button v-on:Click="delStockA(stock.id)" class="btn btn-outline-info btn-sm"><span class="fa fa-trash"></span> Eliminar</button>
											</td>
										</tr>
									</template>
								</template>
								<tr>
									<td colspan="5">Total Stock: @{{ totalStock }}</td>
								</tr>
							</table>
						</div>
					</div>
					<div class="tab-pane fade" id="frmprecio" role="tabpanel">
						<div class="form-row">

	    					<div class="col">
	    						<div class="form-group">
							      <strong><label for="costo">Precio Compra *</label></strong>
							      <input type="number" onkeypress="return soloNumero(event)" v-model="articulo.costo" v-on:keyup="setPrecioVenta()" onfocus="this.select()" class="form-control form-control-sm font-weight-bold" name="costo" placeholder="Precio Compra">
							    </div>
							</div>
						</div>
						<div class="card border-warning py-2 px-2 m-1">
							<strong>Margen de Utilidad %</strong>
							<div class="form-row">
								<div class="col">
									<div class="form-group">
								      <strong><label for="marge1">Precio 1</label></strong>
								      <input v-model="articulo.m1" onfocus="this.select()" v-on:keyup="setUtilPrecio('M',1)" type="number" class="form-control form-control-sm" name="margen1" placeholder="Margen Precio 1">
								    </div>
								</div>
								<div class="col">
								    <div class="form-group">
								      <strong><label for="margen2">Precio 2</label></strong>
								      <input v-model="articulo.m2" onfocus="this.select()" v-on:keyup="setUtilPrecio('M',2)" type="number"  class="form-control form-control-sm" name="margen2" placeholder="Margen Precio 2">
								    </div>
								</div>
								<div class="col">
								    <div class="form-group">
								      <strong><label for="margen3">Precio 3</label></strong>
								      <input v-model="articulo.m3" onfocus="this.select()" v-on:keyup="setUtilPrecio('M',3)" type="number" class="form-control form-control-sm" name="margen3" placeholder="Margen Precio 3">
								    </div>
								</div>
								<div class="col">
								    <div class="form-group">
								      <strong><label for="margen4">Precio 4</label></strong>
								      <input v-model="articulo.m4" onfocus="this.select()" type="number" v-on:keyup="setUtilPrecio('M',4)" class="form-control form-control-sm" name="margen4" placeholder="Margen Precio 4">
								    </div>
								</div>
								<div class="col">
								    <div class="form-group">
								      <strong><label for="margen5">Precio 5</label></strong>
								      <input v-model="articulo.m5" onfocus="this.select()" type="number" v-on:keyup="setUtilPrecio('M',5)" class="form-control form-control-sm" name="margen5" placeholder="Margen Precio 5">
								    </div>
								</div>
							</div>
						</div>
						<div class="card border-warning py-2 px-2 m-1">
							<strong>Precio de Venta</strong>
							<div class="form-row">
								<div class="col">
									<div class="form-group">
								      <strong><label for="venta1">Precio Venta 1 *</label></strong>
								      <input v-model="articulo.p1" onfocus="this.select()" v-on:keyup="setUtilPrecio('P',1)" type="number" class="form-control form-control-sm" name="venta1" placeholder="Precio Venta 1">
								    </div>
								</div>
								<div class="col">
								    <div class="form-group">
								      <strong><label for="venta2">Precio Venta 2</label></strong>
								      <input type="number" onfocus="this.select()" v-model="articulo.p2" v-on:keyup="setUtilPrecio('P',2)" class="form-control form-control-sm" name="venta2" placeholder="Precio Venta 2">
								    </div>
								</div>
								<div class="col">
								    <div class="form-group">
								      <strong><label for="venta3">Precio Venta 3</label></strong>
								      <input v-model="articulo.p3" onfocus="this.select()" v-on:keyup="setUtilPrecio('P',3)" type="number" class="form-control form-control-sm" name="venta3" placeholder="Precio Venta 3">
								    </div>
								</div>
								<div class="col">
								    <div class="form-group">
								      <strong><label for="venta4">Precio Venta 4</label></strong>
								      <input v-model="articulo.p4" onfocus="this.select()" v-on:keyup="setUtilPrecio('P',4)" type="number" class="form-control form-control-sm" name="venta4" placeholder="Precio Venta 4">
								    </div>
								</div>
								<div class="col">
								    <div class="form-group">
								      <strong><label for="venta5">Precio Venta 5</label></strong>
								      <input v-model="articulo.p5" onfocus="this.select()" v-on:keyup="setUtilPrecio('P',5)" type="number" class="form-control form-control-sm" name="venta4" placeholder="Precio Venta 5">
								    </div>
								</div>
							</div>
						</div>
							
					</div>
				</div>
				
			</div>
			<div class="modal-footer">
				<template v-if="error">
			      <div class="alert alert-danger" role="alert">
			        @{{ error }}
			      </div>
			    </template>
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><span class="fa fa-times"></span> Cerrar</button>
				<button type="button" class="btn btn-primary" @click="saveArticulo"><span class="fa fa-save"></span> Guardar</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
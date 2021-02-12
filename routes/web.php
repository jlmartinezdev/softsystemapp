<?php
Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

//Articulos
Route::get('inf/articulo','ArticuloController@informe')->name('articulo@informe');
Route::get('articulo','ArticuloController@index')->name('articulo');
Route::get('articulo/buscar','ArticuloController@getArticulo')->name('articulo@buscar');
Route::get('articulo/ultimo','ArticuloController@getUltimo')->name('articulo@ultimo');
Route::put('articulo','ArticuloController@getByCodigo');
Route::post('articulo/res','ArticuloController@reservarCodigo')->name('articulo@reservarCodigo');
Route::put('articulo/{id}','ArticuloController@update')->name('articulo.update');
Route::delete('articulo/res/{id}','ArticuloController@destroy')->name('articulo.destroy');
//STOCK
Route::delete('stock/{id}','StockController@destroy');
Route::post('stock/{id}','StockController@update');
//VENTA
Route::get('infventa','VentaController@indexInf')->name('infventa');
Route::get('infventa/fecha','VentaController@getVentaByFecha')->name('infventa.fecha');
Route::post('infventa/chart','VentaController@getVentaChart')->name('infventa.chart');
Route::get('infventa/detalle/{id}','VentaController@getDetalle');
Route::get('infventa/articulo','VentaController@getVentaArticulo');
Route::get('venta','VentaController@index')->name('venta');
Route::post('venta','VentaController@store');
//COMPRA
Route::get('compra','CompraController@index')->name('compra');


//CAJA
Route::get('aperturacierre','AperturaController@index')->name('apertura');
Route::post('aperturaciere/open','AperturaController@store')->name('apertura.add');
Route::post('aperturaciere/cierre','AperturaController@update')->name('apertura.close');
Route::get('cierre/{operacion}','AperturaController@indexCierre')->name('cierre');
Route::get('aperturacierre/{sucursal}','AperturaController@getStatu');
Route::get('movimiento','MovimientoCajaController@index')->name('movimiento');
Route::get('movimiento/{nro_operacion}','MovimientoCajaController@getAll');
Route::post('movimiento','MovimientoCajaController@store');

//COBROS
Route::get('infctacobrar','CtaCobrarController@indexInf')->name('infctacobrar');
Route::get('ctas_cobrar/buscar','CtaCobrarController@getCtaCobrar')->name('ctas_cobrar@buscar');
//Usuario
Route::get('usuario','UserController@index')->name('usuario');
Route::get('usuario/all','UserController@showAll')->name('showalluser');
Route::post('usuario','UserController@store');
Route::delete('usuario/{id}','UserController@destroy');

//REFERENCIAL
Route::get('v1/unidad/all','UnidadController@All');
Route::get('seccion/all','SeccionController@All');
Route::get('seccion','SeccionController@index')->name('seccion.index');
Route::post('seccion','SeccionController@store');
Route::post('seccion/{id}','SeccionController@update');
Route::delete('seccion/{id}','SeccionController@destroy');
//SUCURSAL
Route::get('sucursal/all','SucursalController@All');
Route::get('sucursal/set','SucursalController@set')->name('sucursal.set');
//STOCK
Route::get('stock/{id}','StockController@show');

//cliente
Route::get('cliente/buscar','ClienteController@buscar');
Route::get('cliente','ClienteController@index')->name('cliente.index');
Route::delete('cliente/{id}','ClienteController@destroy');
Route::post('cliente','ClienteController@store');
Route::post('cliente/update','ClienteController@update');
//PDF
Route::get('pdf/boletaventa/{id}','VentaController@pdfboleta')->name('pfd.boletaventa');

Route::get('/clear-cache', 'AperturaController@comando');
/*
Modificar fecha en informe
url api buscar en venta


*/
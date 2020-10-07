<?php

namespace App\Http\Controllers;

use App\Cliente;
use Illuminate\Http\Request;
use App\Ciudad;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ciudades= Ciudad::select('CIUDAD_cod','ciudad_nombre')->get();
        return view('cliente',compact('ciudades'));
    }
    public function buscar(Request $request)
    {
        $cliente= Cliente::select('clientes_cod','cliente_ci','cliente_nombre','cliente_direccion','cliente_cel','cliente_correo','ciudad_cod')
        ->nombre(strtoupper($request->nombre))
        ->documento($request->documento)
        ->orderBy('cliente_nombre','ASC')
        ->limit(100)
        ->get();
        return $cliente;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $cliente = new Cliente();
        $cliente->CIUDAD_cod =$request->cliente['idciudad'];
        $cliente->cliente_ci =$request->cliente['doc'];
        $cliente->cliente_nombre =$request->cliente['nombre'];
        $cliente->cliente_ruc =$request->cliente['doc'];
        $cliente->cliente_direccion =$request->cliente['direccion'];
        $cliente->cliente_telef =$request->cliente['celular'];
        $cliente->cliente_cel =$request->cliente['celular'];
        $cliente->cliente_correo =$request->cliente['correo'];
        $cliente->save();
        return 'OK';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $cliente = Cliente::where('clientes_cod','=',$request->cliente['id'])->update(['CIUDAD_cod' =>$request->cliente['idciudad'],'cliente_ci' =>$request->cliente['doc'], 'cliente_nombre' =>$request->cliente['nombre'], 'cliente_ruc' => $request->cliente['doc'], 'cliente_direccion' =>$request->cliente['direccion'], 'cliente_telef' =>$request->cliente['celular'], 'cliente_cel' =>$request->cliente['celular'], 'cliente_correo' =>$request->cliente['correo']]);
        return 'OK';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cliente::where('clientes_cod','=',$id)->delete();
        return 'OK';
    }
}

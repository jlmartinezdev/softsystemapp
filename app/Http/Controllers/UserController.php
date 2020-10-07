<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuario= User::All();
        $cargo= DB::select('SELECT * FROM cargo');
        $roles= DB::select('SELECT * FROM roles');
        return view('usuario',compact('usuario','cargo','roles'));
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
        if($request->band==0){
            $ultimo= User::max('cod_usuarios');
            $user = new User();
            $user->cod_usuarios= $ultimo+1;
            $user->cod_rol=$request->rol;
            $user->cod_cargo=$request->cargo;
            $user->nom_usuarios=$request->nombre;
            $user->user_usuarios=$request->usuario;
            $user->clave_usuarios=md5($request->password);
            $user->tel_usuarios=$request->celular;
            $user->direcc_usuarios=$request->direccion;
            $user->save();

        }else{

             $user=User::where('cod_usuarios',$request->codigo);
             $password= !empty($request->password) ? md5($request->password) : $user->get()[0]['clave_usuarios'];
             $user->update(['cod_rol'=>$request->rol,'cod_cargo'=>$request->cargo,'nom_usuarios'=>$request->nombre,'user_usuarios'=>$request->usuario,'clave_usuarios'=>$password,'tel_usuarios'=>$request->celular,'direcc_usuarios'=>$request->direccion]);
    
        }
        return 'OK';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    public function showAll(){
       return  User::All();
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::where('cod_usuarios',$id)->delete();
    }
}

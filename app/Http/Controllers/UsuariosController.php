<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Models\User;
use App\Models\UsuarioTipoUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUsuarioRequest $request)
    {
        //Guardamos todo lo que viene del formulario en la variable imput
        $imput = $request->all();

        //Incriptacion de la contraseña
        $imput['password']= Hash::make($request->password);

        //creamos el usuario con los valores recibidos
        User::create($imput);
        //optenemos el usuario resien creado
        $lastUser = User::latest('id')->first();

        if ($request->tipoUserSolicitante) {
            //instancioamos el modelo que relaciona a usuarios con tipos de usuarios
            $usuarioTipoUsuario = new UsuarioTipoUsuario();

            $usuarioTipoUsuario->cod_usuario        = $lastUser->id;
            $usuarioTipoUsuario->cod_tipo_usuario   = $request->tipoUserSolicitante;
            $usuarioTipoUsuario->save();
        }
        if ($request->tipoUserPrestador) {
            //instancioamos el modelo que relaciona a usuarios con tipos de usuarios
            $usuarioTipoUsuario = new UsuarioTipoUsuario();

            $usuarioTipoUsuario->cod_usuario        = $lastUser->id;
            $usuarioTipoUsuario->cod_tipo_usuario   = $request->tipoUserPrestador;
            $usuarioTipoUsuario->save();
        }

        return response()->json([
            'res' => true,
            'message'=> 'Usuario Registrado con exitos',
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $usuario)
    {
        return $usuario;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUsuarioRequest $request, $id)
    {
        $imput = $request->all();

        $user =  User::find($id);

        if ($user ->id != Auth::user()->id) {
            return response()->json([
                'res' => false,
                'message'=> 'Solo Puedes editar tu perfil',
            ],401);
        }
        else {
            $user->update($imput);

        if ($request->tipoUserSolicitante == null) {
            //Buscamos la relacion entre el usuario y el tipo de usuario
            $usuarioTipoUsuario =  UsuarioTipoUsuario::where('cod_usuario', $user->id)
                                                    ->where('cod_tipo_usuario',1);
            //borramos la relacion
            $usuarioTipoUsuario->delete();
        }
        else {
            //Buscamos la relacion entre el usuario y el tipo de usuario
            $usuarioTipoUsuario =  UsuarioTipoUsuario::where('cod_usuario', $user->id)
                                                    ->where('cod_tipo_usuario',1)->count();
            //si no existe ninguna relacion la creamos
            if ($usuarioTipoUsuario < 1) {
                //instancioamos el modelo que relaciona a usuarios con tipos de usuarios
                $usuarioTipoUsuario = new UsuarioTipoUsuario();

                $usuarioTipoUsuario->cod_usuario        = $user->id;
                $usuarioTipoUsuario->cod_tipo_usuario   = $request->tipoUserSolicitante;
                $usuarioTipoUsuario->save();
            }
        }
        if ($request->tipoUserPrestador == null) {
            ///Buscamos la relacion entre el usuario y el tipo de usuario
            $usuarioTipoUsuario =  UsuarioTipoUsuario::where('cod_usuario', $user->id)
                                                    ->where('cod_tipo_usuario',2);
            //borramos la relacion
            $usuarioTipoUsuario->delete();
        }
        else {
            //Buscamos la relacion entre el usuario y el tipo de usuario
            $usuarioTipoUsuario =  UsuarioTipoUsuario::where('cod_usuario', $user->id)
                                                    ->where('cod_tipo_usuario',2)->count();
            //si no existe ninguna relacion la creamos
            if ($usuarioTipoUsuario < 1) {
                //instancioamos el modelo que relaciona a usuarios con tipos de usuarios
                $usuarioTipoUsuario = new UsuarioTipoUsuario();

                $usuarioTipoUsuario->cod_usuario        = $user->id;
                $usuarioTipoUsuario->cod_tipo_usuario   = $request->tipoUserPrestador;
                $usuarioTipoUsuario->save();
            }
        }

        return response()->json([
            'res' => true,
            'message'=> 'Usuario Actualizado con exitoso',
        ],200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

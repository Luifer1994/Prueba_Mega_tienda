<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCitaRequest;
use App\Models\Cita;
use App\Models\UsuarioTipoUsuario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CitasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $citas = Cita::select('citas.id','citas.descripcion','citas.cupos_totales', 'citas.cupos_disponibles',
                             'citas.fecha', 'users.razon_social as nombre_prestador')
                        ->join('users', 'citas.cod_usuario_prestador', '=', 'users.id')->get();

        return $citas;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCitaRequest $request)
    {

        $fechaHoy = date("Y-m-d");

        Carbon::parse($fechaHoy)->format("Y-m-d");

        if ($request->fecha <= $fechaHoy) {
            return response()->json([
                'res' => false,
                'message'=> 'La Fecha no puede ser igual o menor a la fecha actual',
            ],401);
        }
        else {
            $newCita = new Cita();

            $newCita->descripcion           =  $request->descripcion;
            $newCita->cupos_totales         =  $request->cupos_totales;
            $newCita->cupos_disponibles     =  $request->cupos_totales;
            $newCita->cod_usuario_prestador =   Auth::user()->id;
            $newCita->fecha                 =  $request->fecha;

            $userPrestador = UsuarioTipoUsuario::where('cod_usuario', Auth::user()->id)
                                                ->where('cod_tipo_usuario', 2)->count();
            if ($userPrestador > 0) {

                $newCita->save();
                return response()->json([
                    'res' => true,
                    'message'=> 'Cita Creada con exito',
                ],200);
            }
            else {
                return response()->json([
                    'res' => false,
                    'message'=> 'Usted no tiene permiso para crear cistas, debes asignarte como prestador para poder hacerlo',
                ],401);
            }
        }

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
        //
    }
}

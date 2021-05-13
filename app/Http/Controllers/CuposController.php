<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Cupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CuposController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cupos = Cupo::select('cupos.id','cupos.cod_cita','users.razon_social as Nombre Solicitante','citas.fecha as Fecha de cita')
                    ->join('users', 'cupos.cod_usuario_solicitante', '=', 'users.id')
                    ->join('citas', 'cupos.fecha_cita', '=', 'citas.fecha')
                    ->where('cod_usuario_solicitante', Auth::user()->id)->get();
        return $cupos;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $citas = Cita::where('id',$request->cod_cita)->where('cupos_disponibles', '>',0)->count();

        if ($citas > 0) {

            $cupos = Cupo::where('cod_cita',$request->cod_cita)->where('cod_usuario_solicitante', Auth::user()->id)->count();

            if ($cupos < 1) {
                $cita = Cita::find($request->cod_cita);

                $cita->cupos_disponibles    =    $cita->cupos_disponibles-1;
                $cita->save();

                $newCupo = new Cupo();
                $newCupo->cod_cita                  =   $request->cod_cita;
                $newCupo->cod_usuario_solicitante   =   Auth::user()->id;
                $newCupo->cod_usuario_prestador     =   $cita->cod_usuario_prestador;
                $newCupo->fecha_cita                =   $cita->fecha;

                $newCupo->save();

                return response()->json([
                    'res' => true,
                    'message'=> 'Cupo Asignado con exito',
                ],200);
            }
            else {
                return response()->json([
                    'res' => false,
                    'message'=> 'Usted ya tiene un cupo para esta cita',
                ],401);
            }


        }
        else {
            return response()->json([
                'res' => false,
                'message'=> 'No hay cupos para esta cita',
            ],401);
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

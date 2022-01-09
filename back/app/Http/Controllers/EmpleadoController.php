<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Empleado;

class EmpleadoController extends Controller
{
    public function __construct()
    {
        //TODOS Exceptuando los metodos del Middleware
        $this->middleware('api.auth',['except' =>
        [

        ]]);
    }
    public function index(Request $request)
    {
        //* Comprobamos que el usuario esta identificado
        $token = $request->header('Authorization');
        $jwtauth = new \JwtAuth();
        $checkToken = $jwtauth->checkToken($token);

        if($checkToken)
        {
            $empleado = Empleado::
            join('persona', 'persona.id', '=', 'empleado.persona_id')->
            select('persona.nombre','persona.apellido', 'empleado.lider','empleado.id')->
            get();

            return response()->json([

                'Code' => 200,
                'Status' => 'success',
                'empleado' => $empleado

            ],200);
        }
        else
        {
                return response()->json([

                    'Code' => 400,
                    'Status' => 'fallo'

                ],400);
        }
    }
    public function store(Request $request)
    {
        // *Recoger el JSON con los datos de usuario por medio del método POST.
        $json = $request->input('json',null);

        //*Se debe decodificar el JSON como parámetro o array.
        $params = json_decode($json); //parámetros en objeto.
        $params_array = json_decode($json,true); //parámetros en array.

        //*Puedes validar si hay datos en los parámetros
        if(!empty($params)&&!empty($params_array))
            {

                //*Limpiar datos recibidos por JSON con el método trim.
                $params_array = array_map('trim', $params_array);

                //todos Validar que los datos sean digitados de manera correcta.
                $validate = \Validator::make($params_array, [
                    'empleado'    =>	    'required'
                ]);
                if($validate->fails())
                {
                    $data = array(
                        'status'	=>	'Error',
                        'code'		=>	404,
                        'message'	=>	'El empleado no se ha creado',
                        'errors'	=>	$validate->errors()
                    );
                }
                else
                    {
                        //*GUARDAMOS EL AREA
                        $empleado = new Empleado();
                        $empleado->empleado = $params_array['empleado'];
                        $empleado->save();

                        //*MENSAJE DE EXITO
                        $data = array(
                            'status'	=>	'success',
                            'code'		=>	200,
                            'message'	=>	'El empleado se ha creado correctamente'
                        );
                    }


            }
            else
            {
                $data = array(
                    'status'	=>	'Error',
                    'code'		=>	404,
                    'message'	=>	'Los datos enviados no son correctos',
                );
            }
            return response()->json($data, $data['code']);
    }
    public function destroy($id, Request $request)
    {
        //* Conseguir el registro
        $empleado = Empleado::where('id',$id)
                    ->first();
        if(!empty($rol))
        {
            //* Borrarlo
            $empleado->delete();
            //* Devolver algo
            $data = array(
                'status'	       =>	'success',
                'code'		       =>	200,
                'message'	       =>	'El registro fue eliminado exitosamente !',
                'rol'	   =>	$rol
                );
        }
        else
        {
            $data = array(
                'status'	=>	'error',
                'code'		=>	400,
                'message'	=>	'No fue posible eliminar el registro'
                );
        }

        return response()->json($data, $data['code']);
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Rol;

class RolController extends Controller
{
    public function __construct()
    {
        //TODOS Exceptuando los metodos del Middleware
        $this->middleware('api.auth',['except' =>
        [

        ]]);
    }
    //! ESTE MÉTODO ME TRAE TODOS LOS ROLES DEL SISTEMA
    public function index(Request $request)
    {
        //* Comprobamos que el usuario esta identificado
        $token = $request->header('Authorization');
        $jwtauth = new \JwtAuth();
        $checkToken = $jwtauth->checkToken($token);

        if($checkToken)
        {
            $rol = Rol::orderBy('rol')->get();

            return response()->json([

                'Code' => 200,
                'Status' => 'success',
                'rol' => $rol

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
    //! METODO PARA GUARDAR ROLES
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
                    'rol'    =>	    'required|alpha'
                ]);
                if($validate->fails())
                {
                    $data = array(
                        'status'	=>	'Error',
                        'code'		=>	404,
                        'message'	=>	'El rol no se ha creado',
                        'errors'	=>	$validate->errors()
                    );
                }
                else
                    {
                        //*GUARDAMOS LOS USUARIOS
                        $rol = new Rol();
                        $rol->rol = $params_array['rol'];
                        $rol->save();

                        //*MENSAJE DE EXITO
                        $data = array(
                            'status'	=>	'success',
                            'code'		=>	200,
                            'message'	=>	'El rol se ha creado correctamente'
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
    //! ESTE MÉTODO ME ELIMINA UN ROL
    public function destroy($id, Request $request)
    {
        //* Conseguir el registro
        $rol = Rol::where('id',$id)
                    ->first();
        if(!empty($rol))
        {
            //* Borrarlo
            $rol->delete();
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

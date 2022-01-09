<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Permiso;

class PermisoController extends Controller
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
            $permiso = Permiso::
            join('empleado', 'empleado.id', '=', 'permiso.empleado_id')->
            join('persona', 'persona.id', '=', 'empleado.persona_id')->
            select(
                'persona.cedula','persona.nombre','persona.apellido',
                'permiso.tipo','permiso.motivo','permiso.fechai','permiso.fechaf',
                'permiso.dias','permiso.observaciones','permiso.estado','permiso.id'
            )->
            get();

            return response()->json([

                'Code' => 200,
                'Status' => 'success',
                'permiso' => $permiso

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
     //! ESTE MÉTODO ME TRAE UN SOLO PERMISO
    public function show($id)
    {
        //$permiso = Permiso::find($id);

        $permiso = Permiso::
            join('empleado', 'empleado.id', '=', 'permiso.empleado_id')->
            join('persona', 'persona.id', '=', 'empleado.persona_id')->
            select('permiso.tipo','permiso.motivo', 'permiso.fechai','permiso.fechaf','permiso.estado'
                ,'permiso.observaciones','permiso.id','persona.nombre','persona.apellido',)->
            find($id);

        if(is_object($permiso))
        {
        $data = array(

            'code' => 200,
            'status' => 'success',
            'permiso' => $permiso
        );
        }
        else
        {
                $data = array
                (
                'code' => 400,
                'status' => 'error',
                'mensaje' => 'Hubo un error en la consulta'
                );
        }
        return response()->json($data, $data['code']);
    }
    //! METODO PARA GUARDAR PERMISOS
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
                $validate = \Validator::    make($params_array, [
                    'tipo'    =>	    'required',
                    'fechai'    =>	        'required',
                    'fechaf'    =>	        'required',
                    'motivo'    =>	        'required'
                ]);
                if($validate->fails())
                {
                    $data = array(
                        'status'	=>	'Error',
                        'code'		=>	404,
                        'message'	=>	'El permiso no se ha creado',
                        'errors'	=>	$validate->errors()
                    );
                }
                else
                    {
                        $fecha1 = date_create($params_array['fechai']);
                        $fecha2 = date_create($params_array['fechaf']);
                        $dias = date_diff($fecha1,$fecha2)->format('%R%a');
                        $fecha = date('Y-m-d');


                        if($params_array['tipo'] == "VACACIONES")
                        {
                            $estado = "PENDIENTE";
                        }
                        else
                        {
                            $estado = "APROBADO";
                        }

                        /* var_dump($params_array);
                        var_dump($dias);
                        var_dump($fecha);
                        var_dump($estado);
                        die(); */

                        //*GUARDAMOS EL PERMISO
                        $permiso = new Permiso();
                        $permiso->tipo = $params_array['tipo'];
                        $permiso->fecha = $fecha;
                        $permiso->fechai = $params_array['fechai'];
                        $permiso->fechaf = $params_array['fechaf'];
                        $permiso->estado = $estado;
                        $permiso->motivo = $params_array['motivo'];
                        $permiso->dias = $dias;
                        $permiso->empleado_id = $params_array['empleado_id'];
                        $permiso->observaciones = $params_array['observaciones'];
                        $permiso->save();

                        //*MENSAJE DE EXITO
                        $data = array(
                            'status'	=>	'success',
                            'code'		=>	200,
                            'message'	=>	'El permiso se ha creado correctamente'
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
        $permiso = Permiso::where('id',$id)
                    ->first();
        if(!empty($permiso))
        {
            //* Borrarlo
            $permiso->delete();
            //* Devolver algo
            $data = array(
                'status'	       =>	'success',
                'code'		       =>	200,
                'message'	       =>	'El registro fue eliminado exitosamente !',
                'permiso'	   =>	$permiso
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
    //! ESTE MÉTODO ME ACTUALIZA LOS PERMISOS
    public function update($id,Request $request)
    {
        //* Comprobamos que el usuario esta identificado
        $token = $request->header('Authorization');
        $jwtauth = new \JwtAuth();
        $checkToken = $jwtauth->checkToken($token);

        // *Recoger el JSON con los datos de usuario por medio del método POST.
        $json = $request->input('json',null);
        //*Se debe decodificar el JSON como parámetro o array.
        $params_array = json_decode($json,true); //parámetros en array.
        //var_dump($params_array);die();
        if($checkToken && !empty($params_array))
        {
            //*Limpiar datos recibidos por JSON con el método trim.
            $params_array = array_map('trim', $params_array);

            // *Validamos la información que vamos a actualizar
            $validate = \Validator::make($params_array, [
                    'tipo'          =>	        'required',
                    'fechai'        =>	        'required',
                    'fechaf'        =>	        'required',
                    'motivo'        =>	        'required',
                    'observaciones' =>	        'required',
            ]);
            if($validate->fails())
                {
                    $data = array(
                        'status'	=>	'error',
                        'code'		=>	404,
                        'message'	=>	'Verifique la información ingresada: ',
                        'error'	=>	$validate->errors()
                    );
                }
                else
                {
                //* quitamos los campos que no vamos a actualizar
                unset($params_array['id']);
                unset($params_array['nombre']);
                unset($params_array['apellido']);
                unset($params_array['created_at']);
                unset($params_array['updated_at']);

                //*Actualizamos el USER en la BD
                $permiso = Permiso::where('id',$id)->update($params_array);

                //*devuevlo un array con el resultado
                $data = array(
                    'status'	=>	'success',
                    'code'		=>	200,
                    'message'	=>	'El permiso se ha actualizado satisfactoriamente !',
                    'actualizado'	    =>	$params_array
                );
                }
        }

        else
        {
            $data = array(
                'status'	=>	'error',
                'code'		=>	400,
                'message'	=>	'El permiso no se ha actualizado'
            );
        }
        return response()->json($data, $data['code']);
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;

class PersonaController extends Controller
    {
        public function __construct()
        {
            //TODOS Exceptuando los metodos del Middleware
            $this->middleware('api.auth',['except' =>
            [
                'index'
            ]]);
        }
        //! ESTE MÉTODO ME TRAE TODAS LAS PERSONAS ORDENADAS POR NOMBRE
        public function index(Request $request)
        {
            //* Comprobamos que el usuario esta identificado
            $token = $request->header('Authorization');
            $jwtauth = new \JwtAuth();
            $checkToken = $jwtauth->checkToken($token);

            if($checkToken)
            {
                $persona = Persona::orderBy('nombre')->get();
                return response()->json([

                    'Code' => 200,
                    'Status' => 'success',
                    'persona' => $persona

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
        //! ESTE MÉTODO ME TRAE LAS PERSONAS QUE COINCIDEN CON UNA BÚSQUEDA
        public function buscar($bq)
        {

            $busqueda = Persona::
                where('nombre', 'LIKE', '%'.$bq.'%')->
                orWhere('apellido', 'LIKE', '%'.$bq.'%')->
                orWhere('direccion', 'LIKE', '%'.$bq.'%')->
                get();

            if(is_object($busqueda))
            {
            $data = array(

                'code' => 200,
                'status' => 'success',
                'busqueda' => $busqueda
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
        //! ESTE MÉTODO ME TRAE UNA SOLA PERSONA
        public function show($id)
        {
            $persona = Persona::find($id);
            if(is_object($persona))
            {
            $data = array(

                'code' => 200,
                'status' => 'success',
                'persona' => $persona
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
        //! ESTE MÉTODO ME ELIMINA UNA PERSONA TOMANDO COMO REFERENCIA EL ID
        public function destroy($id, Request $request)
            {
                //* Conseguir el registro
                $persona = Persona::where('id',$id)
                            ->first();
                if(!empty($persona))
                {
                    //* Borrarlo
                    $persona->delete();
                    //* Devolver algo
                    $data = array(
                        'status'	       =>	'success',
                        'code'		       =>	200,
                        'message'	       =>	'El registro fue eliminado exitosamente !',
                        'persona'	   =>	$persona
                        );
                }
                else
                {
                    $data = array(
                        'status'	=>	'error',
                        'code'		=>	400,
                        'message'	=>	'No fue posible eliminar la persona'
                        );
                }

                return response()->json($data, $data['code']);
            }
            //! ESTE MÉTODO ME ALMACENA LAS PERSONAS
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
                            'cedula'      =>	'numeric|required|unique:persona|min:000000|max:9999999999',
                            'nombre'      =>	'required',
                            'apellido'    =>	'required',
                            'celular'     =>	'required|digits:10',
                            'direccion'   =>    'required',
                            'municipio'   =>    'required',
                            'barrio'      =>    'required',
                            'estcivil'      =>  'required'
                        ]);
                        if($validate->fails())
                        {
                            if($validate->errors()->any())
                            {
                                foreach($validate->errors()->all() as $error)
                                {
                                    $mensaje = $error;
                                }
                            }

                            $data = array(
                                'status'	=>	'error',
                                'code'		=>	400,
                                'message'	=>	$mensaje
                            );
                        }
                        else
                            {
                                //*GUARDAMOS LA PERSONA
                                $persona = new Persona();
                                $persona->cedula = strtoupper($params_array['cedula']);
                                $persona->nombre = strtoupper($params_array['nombre']);
                                $persona->apellido = strtoupper($params_array['apellido']);
                                $persona->fijo = strtoupper($params_array['fijo']);
                                $persona->celular = strtoupper($params_array['celular']);
                                $persona->direccion = strtoupper($params_array['direccion']);
                                $persona->municipio = strtoupper($params_array['municipio']);
                                $persona->barrio = strtoupper($params_array['barrio']);
                                $persona->fechanac = strtoupper($params_array['fechanac']);
                                $persona->estcivil = strtoupper($params_array['estcivil']);
                                $persona->email = strtoupper($params_array['email']);
                                $persona->save();
                                //*MENSAJE DE EXITO
                                $data = array(
                                    'status'	=>	'success',
                                    'code'		=>	200,
                                    'message'	=>	'El registro de la persona fue exitoso!'
                                );
                            }
                    }
                    else
                    {
                        $data = array(
                            'status'	=>	'error',
                            'code'		=>	404,
                            'message'	=>	'Faltan datos por ingresar, por favor verifique.',
                        );
                    }
                    return response()->json($data, $data['code']);
            }
            //! ESTE MÉTODO ME ACTUALIZA LAS PERSONAS
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
                'cedula'      =>	'numeric|required|unique:persona,cedula,'.$id.'|min:000000|max:9999999999',
                'nombre'      =>	'required',
                'apellido'    =>	'required',
                'celular'     =>	'required|digits:10',
                'direccion'   =>    'required',
                'municipio'   =>    'required',
                'barrio'      =>    'required',
                'estcivil'      =>  'required'
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
                unset($params_array['created_at']);
                unset($params_array['updated_at']);

                //* convertimos los datos a mayúsculas
                $params_array_mayus = array
                (
                    'cedula'    =>  strtoupper($params_array['cedula']),
                    'nombre'    =>  strtoupper($params_array['nombre']),
                    'apellido'  =>  strtoupper($params_array['apellido']),
                    'fijo'      =>  strtoupper($params_array['fijo']),
                    'celular'   =>  strtoupper($params_array['celular']),
                    'direccion' =>  strtoupper($params_array['direccion']),
                    'municipio' =>  strtoupper($params_array['municipio']),
                    'barrio'    =>  strtoupper($params_array['barrio']),
                    'fechanac'  =>  strtoupper($params_array['fechanac']),
                    'estcivil'  =>  strtoupper($params_array['estcivil']),
                    'email'     =>  strtoupper($params_array['email'])
                );

                //*Actualizamos el USER en la BD
                $persona_update = Persona::where('id',$id)->update($params_array_mayus);

                //*devuevlo un array con el resultado
                $data = array(
                    'status'	=>	'success',
                    'code'		=>	200,
                    'message'	=>	'La persona se ha actualizado satisfactoriamente !',
                    'actualizado'	    =>	$params_array_mayus
                );
                }
        }

        else
        {
            $data = array(
                'status'	=>	'error',
                'code'		=>	400,
                'message'	=>	'El usuario no se ha actualizado'
            );
        }
        return response()->json($data, $data['code']);
    }
    }



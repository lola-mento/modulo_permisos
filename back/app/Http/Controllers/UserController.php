<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        //TODOS Exceptuando los metodos del Middleware
        $this->middleware('api.auth',['except' =>
        [
            'login',
            'store'
        ]]);
    }
    //! ESTE MÉTODO ME TRAE TODAS LOS USUARIOS POR NOMBRE
    public function index(Request $request)
    {
        //* Comprobamos que el usuario esta identificado
        $token = $request->header('Authorization');
        $jwtauth = new \JwtAuth();
        $checkToken = $jwtauth->checkToken($token);

        if($checkToken)
        {
            $usuario = User::
            join('persona', 'persona.id', '=', 'users.persona_id')->
            join('rol', 'rol.id', '=', 'users.rol_id')->
            select('persona.nombre','persona.apellido', 'users.usuario','users.id','rol.id as rol_id','rol.rol','persona.id')->
            get();

            return response()->json([

                'Code' => 200,
                'Status' => 'success',
                'usuario' => $usuario

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
    public function login(Request $request)
    {
        $jwtauth = new \JwtAuth();
        //todosRecibir datos por POST
        $json = $request->input('json',null);
        $params = json_decode($json);
        $params_array = json_decode($json,true);

        //Validamos la información
        $validate = \Validator::make($params_array, [

            'usuario'     =>    'required',
            'clave'       =>    'required',

        ]);
        if($validate->fails()){

            $signup = array(

                'status'=> 'error',
                'code'=> 404,
                'message'=> 'El Usuario no se ha podido identificar',
                'errors'=>$validate->errors(),
            );
        }
        else
        {
            //todosCifrar la password
            $pwd = hash('sha256',$params->clave);

            //todosDevolver token o datos
            $signup = $jwtauth->signup($params->usuario,$pwd);
            if(!empty($params->getToken))
            {
                $signup = $jwtauth->signup($params->usuario,$pwd,true);
            }
        }
        return response()->json($signup,200);
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
                    'persona_id'    =>	'required|unique:users,persona_id',
                    'usuario'    =>	    'required|alpha|unique:users',
                    'clave'      =>	    'required'
                ]);
                if($validate->fails())
                {
                    $data = array(
                        'status'	=>	'Error',
                        'code'		=>	404,
                        'message'	=>	'El usuario no se ha creado',
                        'errors'	=>	$validate->errors()
                    );
                }
                else
                    {
                        //*CIFRAMOS LA CLAVE DEL USUARIO
                        $pwd = hash('sha256',$params->clave);
                        //*GUARDAMOS LOS USUARIOS
                        $user = new User();
                        $user->rol_id = $params_array['rol_id'];
                        $user->persona_id = $params_array['persona_id'];
                        $user->usuario = $params_array['usuario'];
                        $user->clave = $pwd;
                        $user->save();
                        //*MENSAJE DE EXITO
                        $data = array(
                            'status'	=>	'success',
                            'code'		=>	200,
                            'message'	=>	'El usuario se ha creado correctamente'
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

        if($checkToken && !empty($params_array))
        {
            // *Validamos la información que vamos a actualizar
            $validate = \Validator::make($params_array, [
                'usuario'      =>	    'required|unique:users,usuario',
                'clave'        =>	    'required'
            ]);
            if($validate->fails())
                {
                    $data = array(
                        'status'	=>	'error',
                        'code'		=>	404,
                        'message'	=>	'Usuario y/o clave no permitidos',
                        'errors'	=>	$validate->errors()
                    );
                }
                else
                {
                //* quitamos los campos que no vamos a actualizar
                unset($params_array['id']);
                unset($params_array['persona_id']);
                unset($params_array['created_at']);
                unset($params_array['remember_token']);

                //*Actualizamos el USER en la BD
                $user_update = User::where('id',$id)->update($params_array);

                if($user_update)
                {
                    //*devuevlo un array con el resultado
                    $data = array(
                    'status'	=>	'success',
                    'code'		=>	200,
                    'message'	=>	'El usuario se ha actualizado correctamente'
                );
                }
                else
                {
                    //*devuevlo un array con el resultado
                    $data = array(
                        'status'	=>	'error',
                        'code'		=>	400,
                        'message'	=>	'El usuario no existe en la base de datos');
                }

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

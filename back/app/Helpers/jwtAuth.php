<?php
namespace App\Helpers;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;
use App\Models\User;

Class jwtAuth
{
	Public function __construct()
    {
        $this->key = '###$$%$$#545254iUjHpÑlOikJKSDsjkdiJjkkA465544444$%$$$sja__*';
    }

    public function signup($usuario,$clave,$getToken=null)
        {
        //Buscar si existe el usuario con las credenciales.
        $user = User::where([
            'usuario'     =>  $usuario,
            'clave'       =>  $clave
        ])->first();

        //Comprobar si son correctas.
            $signup = false;
            if(is_object($user))
                {
                    $signup = true;
                }
        //Generar el token con los datos del usuario identificado.
        if($signup)
            {
                $identidad = User::
                    join('persona', 'persona.id', '=', 'users.persona_id')->
                    join('rol', 'rol.id', '=', 'users.rol_id')->
                    select('persona.nombre','persona.apellido', 'users.usuario','users.id','rol.id as rol_id','rol.rol')
                    ->where('users.usuario',$usuario)
                    ->first();

                    $token = array(
                        'sub'         =>    $identidad->id,
                        'usuario'     =>    $identidad->usuario,
                        'nombre'      =>    $identidad->nombre,
                        'apellido'    =>    $identidad->apellido,
                        'rol'         =>    $identidad->nombre,
                        'rol_id'      =>    $identidad->rol_id,
                        'iat'         =>    time(),
                        'exp'         =>    time()+(7*24*60*60)
                        );

                $jwt = JWT::encode($token,$this->key,'HS256');
                $decoded = JWT::decode($jwt,$this->key,['HS256']);

                if(is_null($getToken))
                {
                    $data = $jwt;
                }
                else
                {
                    $data = $decoded;
                }

            }
        else
            {
                $data = array(
                'status'	=>	'error',
                'message'	=>	'Login Incorrecto',
                'codigo'	=>	0
                );
            }
            return $data;
    }

    public function checkToken($jwt, $getIdentity = false)
    {
        $auth = false;
        try{
            $jwt = str_replace('"','',$jwt);
            $decoded = JWT::decode($jwt,$this->key, ['HS256']);
        }catch(\UnexpectedValueException $e){
            $auth = false;
        }catch(\DomainException $e){
            $auth = false;
        }
        if(!empty($decoded) && is_object($decoded) && isset($decoded->sub))
        {
            $auth = true;
        }
        else
        {
            $auth = false;
        }
        if($getIdentity)
        {
            return $decoded;
        }
        return $auth;
    }
}
?>

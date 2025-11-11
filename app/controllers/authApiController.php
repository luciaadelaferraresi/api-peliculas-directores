<?php
require_once './app/models/usuarioModel.php';
require_once './libs/jwt/jwt.php';

class AuthApiController {
    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new UsuarioModel();
    }

    public function login($request, $response) {
      
        $authorization = $_SERVER['HTTP_AUTHORIZATION'] ?? null;

        
        $auth = explode(' ', $authorization);
        if (count($auth) != 2 || $auth[0] !== 'Basic') {
            header("WWW-Authenticate: Basic realm='Get a token'");
            return $response->json("Autenticación no válida", 401);
        }

        $auth = base64_decode($auth[1]); 
        $user_pass = explode(":", $auth);
        if (count($user_pass) != 2) {
            return $response->json("Autenticación no válida", 401);
        }

        $email = $user_pass[0];
        $password = $user_pass[1];

       
        $userFromDB = $this->usuarioModel->getByEmail($email);
        
       
        if (!$userFromDB || !password_verify($password, $userFromDB->password)) {
            return $response->json("Usuario o contraseña incorrecta", 401);
        }

       
        $payload = [
            'sub' => $userFromDB->id,
            'email' => $userFromDB->email,
            'rol' => $userFromDB->rol,
            'exp' => time() + 3600 
        ];

        return $response->json(createJWT($payload));
    }
}
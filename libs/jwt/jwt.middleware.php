<?php

require_once __DIR__ . '/jwt.php';


class JWTMiddleware extends Middleware {
    
    public function run($request, $response) {
       
        if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
            return;
        }
       

        $auth_header = $_SERVER['HTTP_AUTHORIZATION']; 
        $auth_header = explode(' ', $auth_header); 

        
        if (count($auth_header) != 2 || $auth_header[0] !== 'Bearer') {
            return $response->json("Formato de token inválido", 401);
        }

        $jwt = $auth_header[1];

        
        try {
            $user = validateJWT($jwt);
            $request->user = $user;
        } catch (Exception $e) {
            return $response->json("Token inválido o expirado", 401);
        }
    }
}
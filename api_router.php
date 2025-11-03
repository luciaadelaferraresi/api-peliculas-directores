<?php
require_once './libs/router/router.php';
require_once './app/middlewares/guard-api.middleware.php';
require_once './app/middlewares/jwt.middleware.php';

require_once 'app/controllers/directoresController.php';
require_once 'app/controllers/peliculasController.php';

$router= new Router();
$router->addMiddleware(new JWTMiddleware());

$router->addRoute('auth/login',     'GET',     'AuthApiController',    'login');

$router->addRoute('api/peliculas',         'GET',      'TaskApiController',    'getTasks');
$router->addRoute('api/peliculas/:id',     'GET',      'TaskApiController',    'getTask');

$router->addMiddleware(new GuardMiddleware());

$router->addRoute('api/peliculas/:id',     'DELETE',   'TaskApiController',    'deleteTask');
$router->addRoute('api/peliculas',         'POST',     'TaskApiController',    'insertTask');
$router->addRoute('api/peliculas/:id',     'PUT',      'TaskApiController',    'updateTask');

$router->addRoute('api/peliculas/:id/reseñas', 'GET', 'PeliculasController', 'getResenias');
$router->addRoute('api/peliculas/:id/reseñas', 'POST', 'PeliculasController', 'addResenia');
$router->addRoute('api/peliculas/:id/reseñas', 'DELETE', 'PeliculasController', 'deleteResenia');
// rutea
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);


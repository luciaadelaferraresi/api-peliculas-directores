<?php
require_once './libs/router/router.php';
require_once './libs/jwt/jwt.middleware.php';
require_once './app/controllers/authApiController.php';
require_once './app/middlewares/guardMiddleware.php';
require_once './app/controllers/peliculasController.php';
require_once './app/controllers/reseniasController.php';
require_once './app/controllers/directoresController.php';


$router = new Router();
$router->addRoute('auth/login', 'POST', 'AuthApiController', 'login');

$router->addMiddleware(new JWTMiddleware());



$router->addRoute('peliculas', 'GET', 'peliculasController', 'getPeliculas');
$router->addRoute('peliculas/:id', 'GET', 'peliculasController', 'getPelicula');
$router->addRoute('peliculas/:id/resenias', 'GET', 'reseniasController', 'getResenias');


$router->addRoute('peliculas', 'POST', 'peliculasController', 'insertPelicula');
$router->addRoute('peliculas/:id', 'PUT', 'peliculasController', 'updatePelicula');
$router->addRoute('peliculas/:id', 'DELETE', 'peliculasController', 'deletePelicula');


$router->addRoute('directores', 'GET', 'directoresController', 'getDirectores');
$router->addRoute('directores/:id', 'GET', 'directoresController', 'getDirector');


$router->addRoute('directores', 'POST', 'directoresController', 'insertDirector');
$router->addRoute('directores/:id', 'PUT', 'directoresController', 'updateDirector');
$router->addRoute('directores/:id', 'DELETE', 'directoresController', 'deleteDirector');


$router->addMiddleware(new GuardMiddleware());
$router->addRoute('peliculas/:id/resenias', 'POST', 'reseniasController', 'addResenia');
$router->addRoute('resenias/:id', 'DELETE', 'reseniasController', 'deleteResenia');
$router->addRoute('resenias/:id', 'PUT', 'reseniasController', 'updateresenia');
$router->addRoute('resenias/:id', 'GET', 'reseniasController', 'getresenia');

$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);

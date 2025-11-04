<?php
require_once './libs/router/router.php';

require_once './app/controllers/peliculasController.php';
require_once './app/controllers/reseniasController.php';
require_once './app/controllers/directoresController.php';


$router = new Router();

// rutas públicas
$router->addRoute('auth/login', 'POST', 'AuthApiController', 'login');

$router->addRoute('peliculas', 'GET', 'peliculasController', 'getPeliculas');
$router->addRoute('peliculas/:id', 'GET', 'peliculasController', 'getPelicula');
$router->addRoute('peliculas/:id/resenias', 'GET', 'reseniasController', 'getResenias');

// rutas CRUD sin auth
$router->addRoute('peliculas', 'POST', 'peliculasController', 'insertPelicula');
$router->addRoute('peliculas/:id', 'PUT', 'peliculasController', 'updatePelicula');
$router->addRoute('peliculas/:id', 'DELETE', 'peliculasController', 'deletePelicula');

$router->addRoute('peliculas/:id/resenias', 'POST', 'reseniasController', 'addResenia');
$router->addRoute('resenias/:id', 'DELETE', 'reseniasController', 'deleteResenia');

$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);
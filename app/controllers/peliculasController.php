<?php 
require_once './app/models/peliculasModel.php';
class peliculasController{
    private $model;

    public function __construct() {
        $this->model = new peliculaModel();
    }
    public function getPeliculas($req, $res){
        $peliculas = $this->model->getAllPeliculas();
        return $res->json($peliculas, 200);
    }
    
    public function getPelicula($req, $res){
        $peliculaId = $req->params->id;
        $pelicula = $this->model->getPelicula($peliculaId);
        if(!$pelicula){
            return $res->json(['error' => 'Película no encontrada'], 404);
        }
        return $res->json($pelicula, 200);
    }
    public function insertPelicula($req, $res) {
        $titulo = $req->body->titulo ?? '';
        $duracion = $req->body->duracion ?? 0;
        $anio = $req->body->anio ?? 0;
        $portada = $req->body->portada ?? '';
        $id_director = $req->body->id_director ?? null;

        if (!$titulo || !$duracion || !$anio || !$id_director) {
            return $res->json(['error' => 'Faltan datos'], 400);
        }

        $nuevoId = $this->model->insertPelicula($titulo, $duracion, $anio, $portada, $id_director);
        $pelicula = $this->model->getPelicula($nuevoId);

        return $res->json($pelicula, 201);
    }
    public function updatePelicula($req, $res) {
        $peliculaId = $req->params->id;
        $pelicula = $this->model->getPelicula($peliculaId);
        if (!$pelicula) {
            return $res->json(['error' => 'Película no encontrada'], 404);
        }

        $data = $req->body;
        $this->model->updatePelicula($peliculaId, $data);
        $peliculaActualizada = $this->model->getPelicula($peliculaId);

        return $res->json($peliculaActualizada, 200);
    }
    public function deletePelicula($req, $res) {
        $peliculaId = $req->params->id;
        $pelicula = $this->model->getPelicula($peliculaId);
        if (!$pelicula) {
            return $res->json(['error' => 'Película no encontrada'], 404);
        }

        $this->model->deletePelicula($peliculaId);
        return $res->json(['mensaje' => 'Película eliminada correctamente'], 200);
    }

}
<?php
require_once './app/models/reseniasModel.php';
require_once './app/models/peliculasModel.php';
class reseniasController{
    private $model;
    private $modelPeliculas;

    public function __construct() {
        $this->model = new reseniasModel();
        $this->modelPeliculas = new peliculasModel();
    }
    public function getResenias($req, $res) {
        $peliculaId = $req->params->id;

        $usuario = null;
        if (isset($req->query->usuario)) {
            $usuario = $req->query->usuario;
        }
        $puntaje = null;
        if (isset($req->query->puntaje)) {
            $puntaje = $req->query->puntaje;
        }
    
        // ORDEN
        $orderBy = false;
        if (isset($req->query->orderBy)) {
            $orderBy = $req->query->orderBy;
        }
        $orderDir = 'ASC';
        if (isset($req->query->order)) {
            $orderDir = $req->query->order;
        }
    
        // validamos campos permitidos
        if ($orderBy !== false) {
            switch($orderBy) {
                case 'puntaje':
                case 'id':
                    case 'usuario':
                    break;
                default:
                    return $res->json(["error" => "Campo de orden inválido"], 400);
            }
        }
        if ($orderDir != 'asc' && $orderDir != 'desc' && $orderDir != 'ASC' && $orderDir != 'DESC') {
            return $res->json(["error" => "Dirección de orden inválida (use asc o desc)"], 400);
        }
    
        $resenias = $this->model->getReseniasPorPelicula($peliculaId, $usuario, $puntaje, $orderBy, $orderDir);
    
        return $res->json($resenias, 200);
    }
    public function getresenia($req, $res){
        $reseniaId = $req->params->id;

        $resenia = $this->model->getResenia($reseniaId);
        if(!$resenia){
            return $res->json(['error' => 'Reseña no encontrada'], 404);
        }
    
        return $res->json($resenia, 200);
    }
    public function deleteresenia($req, $res){
        $reseniaId = $req->params->id;
        $resenia = $this->model->getResenia($reseniaId);
        if(!$resenia){
            return $res->json(['error' => 'Reseña no encontrada'], 404);
        }

        $resultado = $this->model->deleteResenia($reseniaId);

        if(!$resultado){
            return $res->json(['error' => 'No se pudo eliminar la reseña'], 500);
        }
    
        return $res->json(['mensaje' => 'Reseña eliminada correctamente'], 200);
    }
    public function addresenia($req, $res){
        $peliculaId = $req->params->id;
        if (empty($req->body->usuario) || empty($req->body->comentario) || !isset($req->body->puntaje)) {
            return $res->json(['error' => 'Faltan datos'], 400);
        }
        $pelicula = $this->modelPeliculas->getPelicula($peliculaId);
if (!$pelicula) {
    return $res->json(['error' => 'La película no existe'], 404);
}
        $usuario = $req->body->usuario;
        $comentario = $req->body->comentario;
        $puntaje = $req->body->puntaje;

        $nuevoId = $this->model->addResenia($peliculaId, $usuario, $comentario, $puntaje);

    if (!$nuevoId) {
        return $res->json(['error' => 'Error al guardar la reseña'], 500);
    }

    $resenia = $this->model->getResenia($nuevoId);
    return $res->json($resenia, 201);
    }
    public function updateresenia($req, $res) {
        $reseniaId = $req->params->id;
        $resenia = $this->model->getResenia($reseniaId);
    
        if (!$resenia) {
            return $res->json(['error' => 'Reseña no encontrada'], 404);
        }
    
        if (empty($req->body->usuario) || empty($req->body->comentario) || !isset($req->body->puntaje)) {
            return $res->json(['error' => 'Faltan datos'], 400);
        }
    
        $usuario = $req->body->usuario;
        $comentario = $req->body->comentario;
        $puntaje = $req->body->puntaje;
     
        $this->model->updateResenia($reseniaId, $usuario, $comentario, $puntaje);
    
        $reseniaActualizada = $this->model->getResenia($reseniaId);
        return $res->json($reseniaActualizada, 200);
    }



}
?>
<?php 
require_once './app/models/peliculasModel.php';
class peliculaApiController{
    private $model;

    public function __construct() {
        $this->model = new peliculaModel();
    }
    public function getresenias($req, $res){
        $peliculaId = $req->params->id;
        $resenias = $this->model->getReseniasPorPelicula($peliculaId);
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


}
<?php
require_once 'app/models/directoresModel.php';

class directorController
{
    private $model;

    public function __construct()
    {
        $this->model = new DirectorModel();
    }

    public function getDirectores($req, $res)
    {
        $directores = $this->model->GetDirectores();
        return $res->json($directores, 200);
    }

    public function getDirector($req, $res)
    {
        $directorId = $req->params->id;
        $director = $this->model->GetDirector($directorId);

        if (!$director) {
            return $res->json(['error' => 'Director no encontrado'], 404);
        }

        return $res->json($director, 200);
    }

    public function insertDirector($req, $res)
    {
        $nombre = $req->body->nombre ?? '';
        $nacionalidad = $req->body->nacionalidad ?? '';

        if (!$nombre || !$nacionalidad) {
            return $res->json(['error' => 'Faltan datos (nombre y/o nacionalidad)'], 400);
        }

        $nuevoId = $this->model->InsertDirector($nombre, $nacionalidad);

        $director = $this->model->GetDirector($nuevoId);

        return $res->json($director, 201);
    }

    public function updateDirector($req, $res)
    {
        $directorId = $req->params->id;

        $director = $this->model->GetDirector($directorId);
        if (!$director) {
            return $res->json(['error' => 'Director no encontrado'], 404);
        }

        $nombre = $req->body->nombre ?? '';
        $nacionalidad = $req->body->nacionalidad ?? '';

        if (!$nombre || !$nacionalidad) {
            return $res->json(['error' => 'Faltan datos (nombre y/o nacionalidad)'], 400);
        }

        $this->model->updateDirector($directorId, $nombre, $nacionalidad);

        $directorActualizado = $this->model->GetDirector($directorId);
        return $res->json($directorActualizado, 200);
    }

    public function deleteDirector($req, $res)
    {
        $directorId = $req->params->id;

        $director = $this->model->GetDirector($directorId);
        if (!$director) {
            return $res->json(['error' => 'Director no encontrado'], 404);
        }

        $this->model->deleteDirector($directorId);

        return $res->json(['mensaje' => 'Director eliminado correctamente'], 200);
    }
}

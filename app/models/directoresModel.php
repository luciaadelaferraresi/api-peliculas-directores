<?php
class DirectorModel
{

    private $db;

    public function __construct()
    {
        $this->db = new PDO(
            'mysql:host=localhost;dbname=cine;charset=utf8',
            'root',
            ''
        );
    }

    public function GetDirectores()
    {
        $query = $this->db->prepare("
            SELECT d.id, d.nombre, d.nacionalidad, COUNT(p.id) AS peliculas_count
            FROM directores d
            LEFT JOIN peliculas p ON d.id = p.id_director
            GROUP BY d.id, d.nombre
        ");
        $query->execute();

        $directores = $query->fetchALL(PDO::FETCH_OBJ);
        return $directores;
    }

    public function getDirectoresDestacados()
    {
        $query = $this->db->prepare("
            SELECT d.nombre, d.nacionalidad, COUNT(p.id) AS peliculas_count
            FROM directores d
            LEFT JOIN peliculas p ON d.id = p.id_director
            GROUP BY d.id
            ORDER BY peliculas_count DESC
            LIMIT 5
        ");
        $query->execute();

        $DirectoresDestacados = $query->fetchALL(PDO::FETCH_OBJ);

        return $DirectoresDestacados;
    }


    public function GetDirector($id)
    {
        $query = $this->db->prepare("
           SELECT d.id, d.nombre, d.nacionalidad, COUNT(p.id) AS peliculas_count
           FROM directores d
           LEFT JOIN peliculas p ON d.id = p.id_director
           WHERE d.id = ?
           GROUP BY d.id, d.nombre, d.nacionalidad
        ");
        $query->execute([$id]);

        $director = $query->fetch(PDO::FETCH_OBJ);
        if (!$director) {
            return null;
        }

        $queryPeliculas = $this->db->prepare("
           SELECT id, titulo, duracion, anio
           FROM peliculas
           WHERE id_director = ?
           ORDER BY anio DESC
        ");
        $queryPeliculas->execute([$id]);
        $peliculas = $queryPeliculas->fetchAll(PDO::FETCH_OBJ);
        $director->peliculas = $peliculas;

        return $director;
    }

    public function InsertDirector($nombre, $nacionalidad)
    {
        $query = $this->db->prepare('INSERT INTO directores (nombre,nacionalidad) VALUES (?,?)');
        $query->execute([$nombre, $nacionalidad]);

        return $this->db->lastInsertId();
    }

    public function updateDirector($id, $data)
    {
        $query = $this->db->prepare('UPDATE directores SET nombre=?, nacionalidad=? WHERE id=?');
        $query->execute([$data->nombre, $data->nacionalidad, $id]);
    }

    public function deleteDirector($id)
    {
        $query = $this->db->prepare('DELETE FROM directores WHERE id=?');
        $query->execute([$id]);
    }
}

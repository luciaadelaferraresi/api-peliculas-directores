<?php
class peliculaModel{

    private $db;

    public function __construct(){
        $this->db = new PDO(
            'mysql:host=localhost;dbname=cine;charset=utf8',
            'root',
            ''
        );
    }
    public function getAllPeliculas() {
        $query = $this->db->prepare("SELECT * FROM peliculas");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getPelicula($id) {
        $query = $this->db->prepare("SELECT * FROM peliculas WHERE id = ?");
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }
    public function getReseniasPorPelicula($peliculaId) {
        $query = $this->db->prepare("SELECT * FROM resenias_peliculas WHERE id_pelicula = ?");
        $query->execute([$peliculaId]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

   
    public function getResenia($id) {
        $query = $this->db->prepare("SELECT * FROM esenias_peliculas WHERE id = ?");
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

 
    public function deleteResenia($id) {
        $query = $this->db->prepare("DELETE FROM esenias_peliculas WHERE id = ?");
        return $query->execute([$id]);
    }

    
    public function addResenia($peliculaId, $usuario, $comentario, $puntaje) {
        $query = $this->db->prepare(
            "INSERT INTO resenias (id_pelicula, usuario, comentario, puntaje) 
            VALUES (?, ?, ?, ?)"
        );
        $query->execute([$peliculaId, $usuario, $comentario, $puntaje]);

        return $this->db->lastInsertId();
    }


}
?>
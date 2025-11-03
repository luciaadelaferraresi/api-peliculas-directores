<?php
class peliculaModel{

    private $db

    public function __construct(){
        $this->db = new PDO(
            'mysql:host=localhost;dbname=cine;charset=utf8',
            'root',
            ''
        );
    }
    public function getReseniasPorPelicula($peliculaId) {
        $query = $this->db->prepare("SELECT * FROM resenias WHERE id_pelicula = ?");
        $query->execute([$peliculaId]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    // ✅ Obtener una reseña por ID
    public function getResenia($id) {
        $query = $this->db->prepare("SELECT * FROM resenias WHERE id = ?");
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    // ✅ Eliminar reseña
    public function deleteResenia($id) {
        $query = $this->db->prepare("DELETE FROM resenias WHERE id = ?");
        return $query->execute([$id]);
    }

    // ✅ Agregar reseña
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
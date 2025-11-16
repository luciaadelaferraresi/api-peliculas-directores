<?php
class ReseniasModel {
    private $db;
    public function __construct(){
        $this->db = new PDO(
            'mysql:host=localhost;dbname=cine;charset=utf8',
            'root',
            ''
        );
    }
    public function getReseniasPorPelicula($id_pelicula, $usuario = null, $puntaje = null, $orderBy = false, $orderDir = 'ASC') {
        $sql = "SELECT * FROM resenias_peliculas WHERE id_pelicula = ?";
        $params = [$id_pelicula];
  
        if ($usuario !== null) {
            $sql .= " AND usuario = ?";
            $params[] = $usuario;
        }


        if ($puntaje !== null) {
            $sql .= " AND puntaje = ?";
            $params[] = $puntaje;
        }

    
        if ($orderBy !== false) {
            switch($orderBy) {
                case 'puntaje':
                    $sql .= " ORDER BY puntaje " . $orderDir;
                    break;
                case 'usuario':
                    $sql .= " ORDER BY usuario " . $orderDir;
                    break;
                case 'id':
                    $sql .= " ORDER BY id " . $orderDir;
                    break;
            }
        }
        $query = $this->db->prepare($sql);
        $query->execute($params);
    
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    public function getResenia($id) {
        $query = $this->db->prepare("SELECT * FROM resenias_peliculas WHERE id = ?");
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

 
    public function deleteResenia($id) {
        $query = $this->db->prepare("DELETE FROM resenias_peliculas WHERE id = ?");
        return $query->execute([$id]);
    }

    
    public function addResenia($peliculaId, $usuario, $comentario, $puntaje) {
        $query = $this->db->prepare(
            "INSERT INTO resenias_peliculas (id_pelicula, usuario, comentario, puntaje) 
            VALUES (?, ?, ?, ?)"
        );
        $query->execute([$peliculaId, $usuario, $comentario, $puntaje]);

        return $this->db->lastInsertId();
    }
    public function updateResenia($id, $usuario, $comentario, $puntaje) {
        $query = $this->db->prepare(
            "UPDATE resenias_peliculas 
             SET usuario = ?, comentario = ?, puntaje = ?
             WHERE id = ?"
        );
        return $query->execute([$usuario, $comentario, $puntaje, $id]);
    }
}
?>
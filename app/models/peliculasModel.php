<?php
class peliculasModel{

    private $db;

    public function __construct(){
        $this->db = new PDO(
            'mysql:host=localhost;dbname=cine;charset=utf8',
            'root',
            ''
        );
    }
    public function getPeliculas($orderBy = null) {
        $sql = "SELECT * FROM peliculas";
    
        if ($orderBy) {
            $sql .= " ORDER BY $orderBy";
        }
    
        $query = $this->db->prepare($sql);
        $query->execute();
    
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getPelicula($id) {
        $query = $this->db->prepare("SELECT * FROM peliculas WHERE id = ?");
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }
    public function insertPelicula($titulo, $duracion, $anio, $portada, $id_director) {
        $query = $this->db->prepare("INSERT INTO peliculas (titulo, duracion, anio, portada, id_director) VALUES (?, ?, ?, ?, ?)");
        $query->execute([$titulo, $duracion, $anio, $portada, $id_director]);
    
        return $this->db->lastInsertId();
    }
    public function updatePelicula($id, $data) {
        $query = $this->db->prepare("
            UPDATE peliculas 
            SET titulo = ?, duracion = ?, anio = ?, portada = ?, id_director = ?
            WHERE id = ?
        ");
        $query->execute([
            $data->titulo,
            $data->duracion,
            $data->anio,
            $data->portada,
            $data->id_director,
            $id
        ]);
    }

    public function deletePelicula($id) {
        $query = $this->db->prepare("DELETE FROM peliculas WHERE id = ?");
        $query->execute([$id]);
    }


   
    


}
?>
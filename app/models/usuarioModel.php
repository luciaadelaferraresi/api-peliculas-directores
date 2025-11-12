<?php

class UsuarioModel {
    private $db;

    public function __construct() {
      
        $this->db = new PDO('mysql:host=localhost;dbname=cine;charset=utf8', 'root', '');
    }

    public function getByEmail($email) {
        $query = $this->db->prepare('SELECT * FROM usuarios WHERE email = ?');
        $query->execute([$email]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

   
    public function getAll() {
        $query = $this->db->prepare('SELECT id, email, rol FROM usuarios');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

   
    public function insert($email, $password, $rol = 'user') {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $query = $this->db->prepare('INSERT INTO usuarios (email, password, rol) VALUES (?, ?, ?)');
        $query->execute([$email, $passwordHash, $rol]);
        return $this->db->lastInsertId();
    }
}
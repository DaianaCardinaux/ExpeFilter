<?php

class Database {
    private $host = "localhost";
    private $db = "expefilter";
    private $user = "root";
    private $pass = "";

    public function connect() {
        try {
            $dsn = "mysql:host=$this->host;dbname=$this->db";
            $pdo = new PDO($dsn, $this->user, $this->pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Error en la conexión: " . $e->getMessage());
        }
    }
}

<?php
    class User {
        private $conn;
        public $id;
        public $nome;
        public $email;
        public $cpf;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function inserirUser () {
            $query = "INSERT INTO usuarios (nome, email, cpf) VALUES (:nome, :email, :cpf)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':nome', $this->nome);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':cpf', $this->cpf);
            return $stmt->execute();
        }

        public function alterarUser () {
            $query = "UPDATE usuarios SET nome = :nome, email = :email, cpf = :cpf WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':nome', $this->nome);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':cpf', $this->cpf);
            return $stmt->execute();
        }

        public function deletarUser () {
            $query = "DELETE FROM usuarios WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $this->id);
            return $stmt->execute();
        }

        public function consultarUsers() {
            $query = "SELECT * FROM usuarios";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function buscarPorCpf($cpf) {
            $query = "SELECT id, nome, email, cpf FROM usuarios WHERE cpf = :cpf LIMIT 1";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":cpf", $cpf);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
?>
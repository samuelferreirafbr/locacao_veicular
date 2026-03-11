<?php
    class Veiculo {
        private $conn;
        public $id;
        public $modelo;
        public $fabricante;
        public $placa;
        public $cor;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function inserirVeiculo() {
            $query = "INSERT INTO veiculos (modelo, fabricante, placa, cor) VALUES (:modelo, :fabricante, :placa, :cor)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':modelo', $this->modelo);
            $stmt->bindParam(':fabricante', $this->fabricante);
            $stmt->bindParam(':placa', $this->placa);
            $stmt->bindParam(':cor', $this->cor);
            return $stmt->execute();
        }

        public function alterarVeiculo() {
            $query = "UPDATE veiculos SET modelo = :modelo, fabricante = :fabricante, placa = :placa, cor = :cor WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':modelo', $this->modelo);
            $stmt->bindParam(':fabricante', $this->fabricante);
            $stmt->bindParam(':placa', $this->placa);
            $stmt->bindParam(':cor', $this->cor);
            return $stmt->execute();
        }

        public function deletarVeiculo() {
            $query = "DELETE FROM veiculos WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $this->id);
            return $stmt->execute();
        }

        public function consultarVeiculos() {
            $query = "SELECT * FROM veiculos";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>
<?php
class Emprestimo {
    private $conn;
    public $id;
    public $usuario_id;
    public $veiculo_id;
    public $diaHora_alocado;
    public $diaHora_devolucao;
    public $valorKm;
    public $valorDia;

    public function __construct($db) {
        $this->conn = $db;
    }

    private function verificarUsuarioExistente($usuario_id) {
        $query = "SELECT id FROM usuarios WHERE id = :usuario_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function inserirEmprestimo() {
        if (!$this->verificarUsuarioExistente($this->usuario_id)) {
            echo "Erro: O usuário com ID {$this->usuario_id} não existe.";
            return false;
        }

        $query = "INSERT INTO emprestimos (usuario_id, veiculo_id, diaHora_alocado, diaHora_devolucao, valorKm, valorDia) 
                  VALUES (:usuario_id, :veiculo_id, :diaHora_alocado, :diaHora_devolucao, :valorKm, :valorDia)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':usuario_id', $this->usuario_id);
        $stmt->bindParam(':veiculo_id', $this->veiculo_id);
        $stmt->bindParam(':diaHora_alocado', $this->diaHora_alocado);
        $stmt->bindParam(':diaHora_devolucao', $this->diaHora_devolucao);
        $stmt->bindParam(':valorKm', $this->valorKm);
        $stmt->bindParam(':valorDia', $this->valorDia);
        
        try {
            if ($stmt->execute()) {
                return true;
            } else {
                throw new Exception("Erro ao inserir empréstimo.");
            }
        } catch (Exception $e) {
            echo "Erro: " . $e->getMessage();
            return false;
        }
    }

    public function alterarEmprestimo() {
        if (!$this->verificarUsuarioExistente($this->usuario_id)) {
            echo "Erro: O usuário com ID {$this->usuario_id} não existe.";
            return false;
        }

        $query = "UPDATE emprestimos SET usuario_id = :usuario_id, veiculo_id = :veiculo_id, diaHora_alocado = :diaHora_alocado, diaHora_devolucao = :diaHora_devolucao, valorKm = :valorKm, valorDia = :valorDia WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':usuario_id', $this->usuario_id);
        $stmt->bindParam(':veiculo_id', $this->veiculo_id);
        $stmt->bindParam(':diaHora_alocado', $this->diaHora_alocado);
        $stmt->bindParam(':diaHora_devolucao', $this->diaHora_devolucao);
        $stmt->bindParam(':valorKm', $this->valorKm);
        $stmt->bindParam(':valorDia', $this->valorDia);
        
        return $stmt->execute();
    }

    public function deletarEmprestimo() {
        $query = "DELETE FROM emprestimos WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    public function consultarEmprestimos() {
        $query = "SELECT * FROM emprestimos";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarEmprestimosPorUsuario($usuario_id) {
        $query = "SELECT id, veiculo_id, diaHora_alocado, diaHora_devolucao, valorKm, valorDia FROM emprestimos WHERE usuario_id = :usuario_id";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":usuario_id", $usuario_id);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
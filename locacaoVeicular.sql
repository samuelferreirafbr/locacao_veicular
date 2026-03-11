CREATE DATABASE db_locadoraVeicular
 COLLATE utf8mb4_general_ci
 CHAR SET utf8mb4;

USE db_locadoraVeicular;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    cpf VARCHAR(11) NOT NULL UNIQUE
    
)AUTO_INCREMENT = 100;

CREATE TABLE veiculos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    modelo VARCHAR(100) NOT NULL,
    fabricante VARCHAR(100) NOT NULL,
    placa VARCHAR(10) NOT NULL UNIQUE,
    cor VARCHAR(30) NOT NULL
    
)AUTO_INCREMENT = 200;

CREATE TABLE emprestimos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    veiculo_id INT NOT NULL,
    diaHora_alocado DATETIME NOT NULL,
    diaHora_devolucao DATETIME NOT NULL,
    valorKm DECIMAL(10, 2) NOT NULL,
    valorDia DECIMAL(10, 2) NOT NULL,
CONSTRAINT fk_usuario_id FOREIGN KEY (usuario_id) REFERENCES usuarios (id),
CONSTRAINT fk_veiculo_id FOREIGN KEY (veiculo_id) REFERENCES veiculos (id)

)AUTO_INCREMENT = 1;

ALTER TABLE usuarios MODIFY cpf VARCHAR(14);
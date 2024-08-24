-- Cria o banco de dados
CREATE DATABASE IF NOT EXISTS urna_eletronica;

-- Seleciona o banco de dados
USE urna_eletronica;

-- Cria a tabela candidatos
CREATE TABLE IF NOT EXISTS candidatos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    partido VARCHAR(50) NOT NULL,
    numero_eleitoral INT UNIQUE NOT NULL,
    votos INT DEFAULT 0,
    foto VARCHAR(255) DEFAULT NULL
);

-- Cria a tabela votos
CREATE TABLE IF NOT EXISTS votos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_eleitoral INT,
    voto_tipo ENUM('candidato', 'branco', 'nulo') NOT NULL,
    FOREIGN KEY (numero_eleitoral) REFERENCES candidatos(numero_eleitoral) ON DELETE SET NULL
);

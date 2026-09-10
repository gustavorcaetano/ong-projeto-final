CREATE DATABASE IF NOT EXISTS administrador_gestao_ong CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE administrador_gestao_ong;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    tipo VARCHAR(50) NOT NULL DEFAULT 'user'
);

CREATE TABLE IF NOT EXISTS acoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT,
    imagem_url VARCHAR(255),
    data_acao DATE
);

CREATE TABLE IF NOT EXISTS familias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    dependentes INT DEFAULT 0,
    renda DECIMAL(10,2) DEFAULT 0.00,
    totalEntregas INT DEFAULT 0
);

CREATE TABLE IF NOT EXISTS doacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255),
    email VARCHAR(255),
    valor DECIMAL(10,2) DEFAULT 0.00,
    metodo VARCHAR(50),
    status VARCHAR(50) DEFAULT 'Pendente'
);

CREATE TABLE IF NOT EXISTS solicitacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nomeFamilia VARCHAR(255),
    mensagem TEXT,
    status VARCHAR(50) DEFAULT 'Pendente'
);

INSERT INTO usuarios (email, senha, tipo) 
VALUES ('admin@ong.com', '123456', 'admin');
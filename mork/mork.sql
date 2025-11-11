CREATE DATABASE IF NOT EXISTS mork;

USE mork;

CREATE TABLE IF NOT EXISTS usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email TEXT NOT NULL,
    senha TEXT NOT NULL,
    tipo VARCHAR(20) DEFAULT 'usuario'
);
    CREATE TABLE IF NOT EXISTS avaliacao (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    estrelas INT NOT NULL,
    comentario TEXT NOT NULL
);
    CREATE TABLE IF NOT EXISTS servicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    foto VARCHAR (255) NOT NULL,
    titulo VARCHAR(100) NOT NULL,
    descricao TEXT NOT NULL,
    preco TEXT NOT NULL
);
    CREATE TABLE IF NOT EXISTS contatos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR (255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    mensagem TEXT NOT NULL
);
    INSERT INTO usuario (nome, email, senha, tipo) 
    VALUES 
        ('Sabrina', 'sabrina@gmail.com', '$2y$10$SHLTsXE3JZvop0caXPXFg.02T1iV2.g.cD59sDhI0hB0tW6GieisO', 'usuario'),
        ('Davi', 'davi@gmail.com', '$2y$10$PJMI5ST.k1PhRuY65yJWZemGZgDgaym9I50PSDWsZNckQYzUbkLkm', 'usuario'),
        ('Morgana', 'morgana@gmail.com', '$2y$10$hX5C7.drXpVcP2nPya6aUOnOs1mOIjyDft3tYZv5El4yVgDJSATNe', 'usuario'),
        ('Agatha', 'agatha@gmail.com', '$2y$10$JWmJAndcxokViZGYxqBlDOVPv73xqRaTj5IlPbWLzNd7et8z0PIIm', 'usuario'),
        ('Edgar', 'edgar@gmail.com', '$2y$10$IhngOSsLmRme97F6AtL9/OUtpR.Mbv4b4kFT1QlxA5QpgdAk1jUZi', 'usuario');

    INSERT INTO avaliacao (nome, estrelas, comentario) 
    VALUES
        ('Sabrina', 5, 'Maravilhoso, recomendo demais!'),
        ('Davi', 4, 'Muito bom, mas pode melhorar.'),
        ('Morgana', 5, 'Atendimento perfeito!'),
        ('Edgar', 3, 'Ok, nada demais.'),
        ('Agatha', 5, 'Amei, experiência impecável!');

    INSERT INTO contatos (nome, email, mensagem)
    VALUES
        ('Sabrina', 'sabrina@gmail.com', 'Gostaria de saber as variações disponíveis.'),
        ('Davi', 'davi@gmail.com', 'Vocês entregam aos sábados?'),
        ('Morgana', 'morgana@gmail.com', 'Quero Devolução'),
        ('Agatha', 'agatha@gmail.com', 'Qual o valor da entrega?'),
        ('Edgar', 'edgar@gmail.com', 'Parabéns pelo atendimento!');

    INSERT INTO servicos (foto, titulo, descricao, preco)
    VALUES
    
    ('imgs/prod/foto_691299db72b091.31928228.png', 'Estojo Mork', 'Arte Coelho', 'R$24,99'),
    ('imgs/prod/foto_691298e174b9d5.06207347.png', 'Caderno Mørk', '500 Paginas', 'R$59,99'),
    ('imgs/prod/foto_69129908f014c2.93433060.png', 'Garrafa Termica', 'Arte Morcega', 'R$79,99'),
    ('imgs/prod/foto_691299b3ca5649.49606773.png', 'Ecobag Mørk', 'Arte Ampulheta', 'R$32,99'),
    ('imgs/prod/foto_69129945668c49.27874626.png', 'Chaveiro Mork', 'Personalizavel', 'R$7,99'),
    ('imgs/prod/foto_691299720a54d7.76237237.png', 'Bloco de Notas', 'Arte Morcegos', 'R$19,99');
    





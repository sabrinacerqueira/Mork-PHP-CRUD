<?php
$host ='localhost';
$banco = 'mork';
$usuario = 'root';
$senha = ''; 

try{
    $pdo = new PDO("mysql:host=$host;dbname=$banco", $usuario,$senha); 
}catch(PDOException $e){
    die("Erro na conexão: " . $e->getMessage());
}
$check = $pdo->prepare("SELECT id FROM usuario WHERE email = 'admin@mork.com'");
$check->execute();

if ($check->rowCount() == 0) {
    $senhaHash = password_hash("1234", PASSWORD_DEFAULT);
    $criarAdmin = $pdo->prepare(
        "INSERT INTO usuario (nome, email, senha, tipo) VALUES ('Admin', 'admin@mork.com', ?, 'admin')"
    );
    $criarAdmin->execute([$senhaHash]);
}
?>
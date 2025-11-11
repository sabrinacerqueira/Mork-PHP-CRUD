<?php
    require 'config.php';

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $senha_hash = password_hash($_POST['senha'], PASSWORD_DEFAULT);

        $query = $pdo->prepare("INSERT INTO usuario (nome, email, senha)
        VALUE(?,?,?)");

        $query->execute([$_POST['nome'], $_POST['email'], $senha_hash]);

        header("Location: index.php");
        exit;
    }

?>
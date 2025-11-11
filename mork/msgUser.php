<?php
    require 'config.php';

    if (isset($_SESSION['usuario_id'])) {
        $query = $pdo->prepare('SELECT nome, email FROM usuario WHERE id = ?');
        $query->execute([$_SESSION['usuario_id']]);
        $usuario = $query->fetch();
}

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $sqlcontato = $pdo->prepare("INSERT INTO contatos (nome, email, mensagem)
        VALUE(?,?,?)");

        $sqlcontato->execute([$_POST['nome'], $_POST['email'], $_POST['mensagem']]);

        header("Location: index.php");
        exit;
    }

?>
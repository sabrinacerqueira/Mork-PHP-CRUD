<?php
    require 'config.php';

   session_start();

   if($_SERVER['REQUEST_METHOD']==='POST'){
        $email=$_POST['email'];
        $senha=$_POST['senha'];

        $query = $pdo->prepare('SELECT * FROM usuario WHERE email = ?');
        $query->execute(([$email]));
        $usuario = $query->fetch();

    if ($usuario && password_verify($senha, $usuario['senha'])) {
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario_nome'] = $usuario['nome'];
    $_SESSION['tipo'] = $usuario['tipo'];

    if ($usuario['tipo'] === "admin") {
        header("Location: dashboard.php");
        exit;
    } else {
        header("Location: index.php");
        exit;
    }
  }else{
        header("Location: index.php?erro=1");
    }
}
?>
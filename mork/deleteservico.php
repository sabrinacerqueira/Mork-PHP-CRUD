<?php
    require 'config.php';
    if (isset($_GET['id'])){
        $query = $pdo->prepare("DELETE FROM servicos WHERE id = ?");
        $query->execute([$_GET['id']]);
    }
    header("Location: produtos.php");
    exit
?>
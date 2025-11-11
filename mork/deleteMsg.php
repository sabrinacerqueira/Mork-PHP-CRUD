<?php
    require 'config.php';
    if (isset($_GET['id'])){
        $query = $pdo->prepare("DELETE FROM contatos WHERE id = ?");
        $query->execute([$_GET['id']]);
    }
    header("Location: contatos.php");
    exit
?>
<?php
require 'config.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$idProduto = $_GET['id'];

$query = $pdo->prepare("SELECT * FROM servicos WHERE id = ?");
$query->execute([$idProduto]);
$produto = $query->fetch();

if (!$produto) {
    echo "Produto não encontrado.";
    exit;
}

header("Location: avaliacaouser.php?id=" . $idProduto);
exit;
?>

<?php
    session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] !== 'admin') {
    header("Location: index.php");
    exit;
}
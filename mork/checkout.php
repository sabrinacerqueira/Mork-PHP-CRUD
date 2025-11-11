<?php
require 'config.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

$query = $pdo->prepare("SELECT nome FROM usuario WHERE id = ?");
$query->execute([$_SESSION['usuario_id']]);
$usuario = $query->fetch();

$produto = false;
if (isset($_GET['id'])) {
    $idProduto = $_GET['id'];
    $query2 = $pdo->prepare("SELECT * FROM servicos WHERE id = ?");
    $query2->execute([$idProduto]);
    $produto = $query2->fetch();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="imgs/Coelho.jfif">
    <title>Checkout</title>
    <link rel="stylesheet" href="styledashboard.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rye&display=swap" rel="stylesheet">
</head>

<body>

<header>
    <nav class="menufixo-dashboard">
        <img src="imgs/Logo invertida sn.png" alt="Imagem Logo" id="logo">

        <?php if (isset($_SESSION['usuario_id']) && $_SESSION['tipo'] == "usuario") { ?>
            <a href="#" onclick="abrirForm('logout')">&#9830; <?= $usuario['nome'] ?> &#9830;</a>
            <a href="index.php">&#9830; Voltar &#9830;</a>
        <?php } else {
            header("Location: index.php");
        } ?>
    </nav>
</header>

<section id="telaDashboard">

    <div id="fundoescuro-logout" onclick="fecharForm('logout')">
        <div id="formulario-logout" onclick="event.stopPropagation()">
            <form action="logout.php" method="post" class="form-container">
                <h1>&#9830; Sair da Conta &#9830;</h1>
                <button type="submit" class="btn">Sair</button>
                <button type="button" class="btn cancel" onclick="fecharForm('logout')">Cancelar</button>
            </form>
        </div>
    </div>

    <div class="produtos_carrinho">

        <?php if ($produto) { ?>
            <div class="card" style="max-width: 400px;">
                <img src="<?= $produto['foto'] ?>" alt="<?= $produto['titulo'] ?>">
                <h1><?= $produto['titulo'] ?></h1>
                <p><?= $produto['descricao'] ?></p>
                <p><?php echo $produto  ['preco'];?></p>

                <form method="get" action="finalizar.php">
                    <input type="hidden" name="id" value="<?= $produto['id'] ?>">
                    <input type="submit" value="Finalizar Compra" class="button">
                </form>
            </div>
        <?php } else { ?>
            <p style="color:white; text-align:center; font-size:20px;">Produto não encontrado.</p>
        <?php } ?>

    </div>

</section>

<script>
function abrirForm(tipo) {
    if (tipo === 'logout') {
        document.getElementById('fundoescuro-logout').style.display = 'flex';
    }
}

function fecharForm(tipo) {
    if (tipo === 'logout') {
        document.getElementById('fundoescuro-logout').style.display = 'none';
    }
}
</script>

</body>
</html>

<?php
require 'config.php';
require 'verificaradmin.php';
if (isset($_SESSION['usuario_id'])) {
    $query = $pdo->prepare('SELECT nome, email FROM usuario WHERE id = ?');
    $query->execute([$_SESSION['usuario_id']]);
    $usuario = $query->fetch();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="imgs/Coelho.jfif">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rye&display=swap" rel="stylesheet">
</head>
<body> 
    
    <header>
        <!-- Menu -->
       
        <nav class="menufixo-dashboard">
            <img src="imgs/Logo invertida sn.png" alt="Imagem Logo" id="logo">
              
            <?php 
                if (isset($_SESSION['usuario_id'])&& $_SESSION ['tipo']=="admin") {
                ?>
                    <a href="#" onclick="abrirForm('logout')"><?php echo "&#9830; ".$usuario['nome'] ." &#9830;"; ?></a>
                    <a href="index.php">&#9830; Início &#9830;</a>
                <?php
                }
                if(isset($_SESSION['usuario_id'])&& $_SESSION ['tipo']=="usuario"){
                header("Location: index.php");
                }
            ?>
      
    </nav>
    </header>

    <main>
    <section id="telaDashboard">
     <div id="fundoescuro-logout"  onclick="fecharForm('logout')">
            <div class="form-popup"></div>
                <div id="formulario-logout" onclick="event.stopPropagation()">
                    <form action="logout.php" method="post" class="form-container">
                    <div>
                        <h1>&#9830; Sair da Conta &#9830;</h1>
                        <br><br>
                        </div>
                        <button type="submit" class="btn">Sair</button>
                        <button type="button" class="btn cancel" onclick="fecharForm('logout')">Cancelar</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
<script>
    
    function abrirForm(tipo) {
    if (tipo === 'login') {
        document.getElementById('fundoescuro-login').style.display = 'flex';
        document.getElementById('fundoescuro-cadastro').style.display = 'none';
        document.getElementById('fundoescuro-logout').style.display = 'none';
    } else if (tipo === 'cadastro') {
        document.getElementById('fundoescuro-cadastro').style.display = 'flex';
        document.getElementById('fundoescuro-login').style.display = 'none';
        document.getElementById('fundoescuro-logout').style.display = 'none';
    }else if (tipo === 'logout') {
        document.getElementById('fundoescuro-logout').style.display = 'flex';
        document.getElementById('fundoescuro-cadastro').style.display = 'none';
        document.getElementById('fundoescuro-login').style.display = 'none';
    }
    }

    function fecharForm(tipo) {
    if (tipo === 'login') {
        document.getElementById('fundoescuro-login').style.display = 'none';
    } else if (tipo === 'cadastro') {
        document.getElementById('fundoescuro-cadastro').style.display = 'none';
    }else if (tipo === 'logout') {
        document.getElementById('fundoescuro-logout').style.display = 'none';
    }
    }

</script>
        <!-- ITENS DASHBOARD -->
        <div class="produtos_carrinho">
        <section id="produtos">

            <div class="card-dashboard">
                <img src="https://cdn-icons-png.flaticon.com/128/2893/2893811.png"  class="icones">
                <h1>Avaliações</h1>
                <a href="avaliacoes.php" ><input class="button" type="button" value="Acessar"></a>
            </div>
                
            <div class="card-dashboard">
                <img src="https://cdn-icons-png.flaticon.com/128/29/29302.png"  class="icones">
                <h1>Produtos</h1>
                <a href="produtos.php" ><input class="button" type="button" value="Acessar"></a>
            </div>
                
            <div class="card-dashboard">
                <img src="https://cdn-icons-png.flaticon.com/128/6244/6244710.png"  class="icones">
                <h1>Mensagens</h1>
                <a href="contatos.php" ><input class="button" type="button" value="Acessar"></a>
            </div>

            <div class="card-dashboard">
                <img src="http://cdn-icons-png.flaticon.com/128/681/681494.png"  class="icones">
                <h1>Usuários</h1>
                <a href="usuarios.php"><input class="button" type="button" value="Acessar"></a>
            </div>
         </section>
    </div>
</section>
</body>
</html>
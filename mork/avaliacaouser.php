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

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $query = $pdo->prepare("INSERT INTO avaliacao (nome, estrelas, comentario)
            VALUE(?,?,?)");

            $query->execute([$_POST['nome'], (int)$_POST['estrelas'], $_POST ['comentario']]);
            header("Location: index.php");
            exit;
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
        <!-- Menu -->
        <nav class="menufixo-dashboard">
            <img src="imgs/Logo invertida sn.png" alt="Imagem Logo" id="logo">
              
            <?php 
                if (isset($_SESSION['usuario_id'])&& $_SESSION ['tipo']=="usuario") {
                ?>
                    <a href="#" onclick="abrirForm('logout')"><?php echo "&#9830; ".$usuario['nome'] ." &#9830;"; ?></a>
                    <a href="index.php">&#9830; Início &#9830;</a>
                <?php
                }
                else{
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
      <section id="contato">
              
        <h1>&#9824; Avalie sua experiência conosco &#9824;</h1>
        <form action ="#" method="post" class="formulario">
            <label> Nome: </label><br>
            <input type ="text" name ="nome" required><br><br>

            <label> Estrelas (1 a 5) </label><br>
            <input type ="number" name ="estrelas" min="1" max="5" required><br><br>

            <label> Comentário: </label><br>
            <textarea name="comentario" rowns="4" cols="50" required></textarea><br><br>

            <button type="submit" class="button">Enviar</button>
        </form>   
        </section>
    </body>
    </html>
<?php
    require 'config.php';
    require 'verificaradmin.php';


        if (isset($_SESSION['usuario_id'])) {
        $query = $pdo->prepare('SELECT nome, email FROM usuario WHERE id = ?');
        $query->execute([$_SESSION['usuario_id']]);
        $admin  = $query->fetch();
    }
        $query = $pdo->query("SELECT * FROM usuario");  
        $usuarios = $query->fetchAll();

        $query = $pdo->prepare("SELECT * FROM usuario WHERE id = ?");
        $id= $_GET['id'];
        $query->execute([$id]);
        $usuario = $query->fetch();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $senha_hash = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    
            $query =$pdo->prepare("UPDATE usuario SET nome = ?, email = ?, senha = ? WHERE id=?");
            $query->execute([$_POST['nome'], $_POST['email'], $senha_hash, $id]);

            header("Location: usuarios.php");
            exit;
        }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="imgs/Coelho.jfif">
    <title>Editar Usuário</title>
    <link rel="stylesheet" href="styledashboard.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rye&display=swap" rel="stylesheet">
</head>
<header>
       
        <nav class="menufixo-dashboard">
            <img src="imgs/Logo invertida sn.png" alt="Imagem Logo" id="logo">
            <?php 
                if (isset($_SESSION['usuario_id'])&& $_SESSION ['tipo']=="admin") {
                ?>
                 <a href="index.php">&#9830; Início &#9830;</a>
                 <a href="#" onclick="abrirForm('logout')"><?php echo "&#9830; ".$admin['nome'] ." &#9830;"; ?></a>
                 <a href="usuarios.php">&#9830; Voltar &#9830;</a>
                <?php
                }
                if(isset($_SESSION['usuario_id'])&& $_SESSION ['tipo']=="usuario"){
                header("Location: index.php");
                }
            ?>
      
    </nav>
    </header>
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
   if (tipo === 'logout') {
        document.getElementById('fundoescuro-logout').style.display = 'flex';
        document.getElementById('fundoescuro-cadastro').style.display = 'none';
        document.getElementById('fundoescuro-login').style.display = 'none';
    }
    }

    function fecharForm(tipo) {
   if (tipo === 'logout') {
        document.getElementById('fundoescuro-logout').style.display = 'none';
    }
    }

</script>

<body>
    <h1> Editar Usúario</h1>
     <section id="contato">
    <form action ="#" method="post" class="formulario">
         <br>
        <label> Nome </label>
        <input type ="text" value="<?php echo $usuario['nome'];?>" name ="nome" required><br><br>

        <label> Email </label>
        <input type ="text" value="<?php echo $usuario['email'];?>" name ="email" required><br><br>

        <label for="psw">Senha</label>
        <input type="password" placeholder="Digite a Senha" name="senha" required>

        <input type ="submit" value="Atualizar">

    </form>   
     </section>
   
</body>
</html>
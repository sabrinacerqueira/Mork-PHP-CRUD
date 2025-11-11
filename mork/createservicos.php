<?php
    require 'config.php';
    require 'verificaradmin.php';

    if (isset($_SESSION['usuario_id'])) {
        $query = $pdo->prepare('SELECT nome, email FROM usuario WHERE id = ?');
        $query->execute([$_SESSION['usuario_id']]);
        $usuario = $query->fetch();
}

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        if(isset($_FILES['foto'])&& $_FILES['foto']['error']=== UPLOAD_ERR_OK){
            $extensao = pathinfo($_FILES['foto']['name'],PATHINFO_EXTENSION);
            $nome_arquivo = uniqid('foto_', true). "." . $extensao;
            $caminho_foto ='imgs/prod/'. $nome_arquivo;

            if(!move_uploaded_file($_FILES['foto']['tmp_name'],$caminho_foto)){
                echo "Erro ao salvar a foto.";
            } 
        }  
        else{
                echo "Erro no upload da foto.";
            }

        $query = $pdo->prepare("INSERT INTO servicos (foto, titulo, descricao, preco)
        VALUE(?,?,?,?)");

        $query->execute([$caminho_foto, $_POST['titulo'], $_POST['descricao'], $_POST['preco']]);

        header("Location: produtos.php");
        exit;
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="imgs/Coelho.jfif">
    <title>Produtos</title>
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
                    <a href="#" onclick="abrirForm('logout')"><?php echo "&#9830; ".$usuario['nome'] ." &#9830;"; ?></a>
                    <a href="dashboard.php">&#9830; Voltar &#9830;</a>
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
    <h1>Novo Produto</h1>
     <section id="contato">
    <form action="#" method="post" enctype="multipart/form-data" class="formulario">
    <br>
        <label>Foto </label><input type ="file" name ="foto" accept="image/*"><br><br>

        <label>Titulo </label><input type ="text" name ="titulo" required><br><br>

        <label>Descrição </label><input type ="text" name ="descricao" required><br><br>

        <label>Preço</label><input type ="text" name ="preco" required><br><br>

        <input type ="submit" value="Salvar">
    </section>
    </form>   
</body>
</html>
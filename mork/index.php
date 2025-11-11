<?php
    session_start();
    require 'config.php';

    $queryservicos = $pdo->query("SELECT * FROM servicos");  
    $servicos = $queryservicos->fetchAll();

    $ordemAva = $_GET['ordemAva'] ?? 'recentes';
switch ($ordemAva) {
    case 'antigas':
        $orderAva = "ORDER BY id ASC";
        break;
    case 'melhores':
        $orderAva = "ORDER BY estrelas DESC";
        break;
    case 'piores':
        $orderAva = "ORDER BY estrelas ASC";
        break;
    default:
        $orderAva = "ORDER BY id DESC";
}

try {
    $sqlAvaliacao = "SELECT nome, estrelas, comentario FROM avaliacao $orderAva LIMIT 3";
    $stmtAva = $pdo->query($sqlAvaliacao);
    $avaliacoes = $stmtAva->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $avaliacoes = [];
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="imgs/Coelho.jfif">
    <title>Mørk</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rye&display=swap" rel="stylesheet">
</head>
<body>

    <header>
        <!-- Menu -->

    <?php //menu admin
            if (isset($_SESSION['usuario_id']) && $_SESSION['tipo'] === "admin") { 
                
                $query = $pdo->prepare('SELECT nome FROM usuario WHERE id = ?');
                $query->execute([$_SESSION['usuario_id']]);
                $usuario = $query->fetch(); 
    ?>
                <nav class="menufixo">
                    <a href="#" onclick="abrirForm('logout')">&#9830; <?= $usuario['nome'] ?> &#9830;</a>
                    <a href="dashboard.php">&#9830; Painel &#9830;</a>
                    <img src="imgs/Logo invertida sn.png" alt="Imagem Logo" id="logo">
                    <a href="#produtos"> &#9830; Produtos &#9830;</a>
                    <a href="#contato">&#9830; Contato &#9830;</a>
                   
                </nav>

    <?php  //menu usuario
            }else if (isset($_SESSION['usuario_id']) && $_SESSION['tipo'] === "usuario") {
                $query = $pdo->prepare('SELECT nome FROM usuario WHERE id = ?');
                $query->execute([$_SESSION['usuario_id']]);
                $usuario = $query->fetch();
    ?>
                <nav class="menufixo">
                    <a href="#" onclick="abrirForm('logout')">&#9830; <?= $usuario['nome'] ?> &#9830;</a>
                    <a href="#produtos"> &#9830; Produtos &#9830;</a>
                    <img src="imgs/Logo invertida sn.png" alt="Imagem Logo" id="logo">
                    <a href="#meio">&#9830; Sobre Nós &#9830;</a>
                    <a href="#contato">&#9830; Contato &#9830;</a>
                </nav>
    <?php
        }else {//menu padrao
    ?>
                <nav class="menufixo">
                    <a href="#" onclick="abrirForm('login')">&#9830; Login &#9830;</a>
                    <a href="#produtos"> &#9830; Produtos &#9830;</a>
                    <img src="imgs/Logo invertida sn.png" alt="Imagem Logo" id="logo">
                    <a href="#meio">&#9830; Sobre Nós &#9830;</a>
                    <a href="#contato">&#9830; Contato &#9830;</a>
                </nav>
            
    <?php } ?>
    
    </header>

    <main>
        <!-- Apresentação -->
        <section id="topo" class="boxtexto">
            <h1>&#9830; Mørk &#9830;</h1>
            <p>Papelaria Alternativa</p>
            <?php
                if (isset($_SESSION['usuario_id'])) {
                $query = $pdo->prepare('SELECT nome, email FROM usuario WHERE id = ?');
                $query->execute([$_SESSION['usuario_id']]);
                $usuario = $query->fetch();
                }
                if(isset($_SESSION['usuario_id'])) {
            ?>
               <img src="imgs/ornamento2.png" id="ornamento">
                <br><p>&#9830; Boas-vindas, <?php echo "".$usuario['nome'] ." ! &#9830;"; ?></p>
            <?php
                    
                }
                else if (!isset($_SESSION['usuario_id'])) {
            ?>
                <img src="imgs/ornamento2.png" id="ornamento">
                <p>Entre no universo Mørk — Cadastre-se e faça parte.</p>
                <a href="#" onclick="abrirForm('cadastro')" class="button">Inscreva-se Agora</a>
                 <?php
                }
            ?>
        </section>
    <!-- Produtos -->
     <br><br>
    <h1> &#9824; Produtos &#9824;</h1>
    <section id="produtos">
    <div class="produtos_carrinho">
        <?php if(!empty($servicos)){ 
        foreach($servicos as $s){ ?>
         <a href="checkout.php?id=<?= $s['id'] ?>">
            <div class="card">
                <img src="<?php echo $s['foto']; ?>" alt="<?php echo $s['titulo'];?>" class="bloco">
                <h1><?php echo $s['titulo'];?></h1>
                <p><?php echo $s['descricao'];?></p>
                <p><?php echo $s['preco'];?></p>
            <?php  
            if(isset($_SESSION['usuario_id'])){ ?>
                <a href="checkout.php?id=<?= $s['id'] ?>" class="btnComprar">
                    <input class="button" type="button" value="Comprar">
                </a>
            <?php } else{ ?>
                <a href="#" class="btnComprar" onclick="abrirForm('login')" ><input class="button" type="button" value="Comprar"></a>
            <?php } ?>
            </div>
            </a>
        <?php }
        } else{ ?>
             <p>Nenhum produto disponível.</p>
        <?php } ?>
    </div>
</section>
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
            <!-- POP-UP LOGIN-->

    <div id="fundoescuro-login"  onclick="fecharForm('login')">
        <div class="form-popup"></div>
            <div id="formulario-login" onclick="event.stopPropagation()">
                <form action="login.php" method="post" class="form-container">
                <div>
                    <h1>&#9830; Login &#9830;</h1>
                    <?php
                        if (isset($_GET['erro']) && $_GET['erro'] == 1) {
                        echo "<script>abrirForm('login');</script>";
                        echo "<p>Email e/ou senha incorretos</p>";
                        }
                    ?>
                    <br><br>
                    </div>
                    <label for="email">Email</label><br>
                    <input type="text" placeholder="Enter Email" name="email" required>
                    <br>
                    <label for="psw">Senha</label><br>
                    <input type="password" placeholder="Enter Password" name="senha" required>
                    <button type="submit" class="btn">Login</button>
                    <button type="button" class="btn cancel" onclick="fecharForm('login')">Fechar</button>
                    <p>Não tem conta?<a href="#" onclick="abrirForm('cadastro')">Cadastre-se</a></p>
                    
                </form>
                </div>
            </div>
        </div>
    </div>
    <!-- POP-UP CADASTRO-->

    <div id="fundoescuro-cadastro" onclick="fecharForm('cadastro')">
        <div class="form-popup"></div>
            <div id="formulario-cadastro" onclick="event.stopPropagation()">
                <form action="cadastro.php" method="post" class="form-container">
                 <div>
                    <h2>&#9830; Cadastro &#9830;</h2>
                    <br>
                    </div>
                    <label for="nome">Nome</label><br>
                    <input type="text" placeholder="Digite o nome" name="nome" required>
                    <br>
                    <label for="email">Email</label><br>
                    <input type="text" placeholder="Digite o Email" name="email" required>
                    <br>
                    <label for="psw">Senha</label><br>
                    <input type="password" placeholder="Digite a Senha" name="senha" required>
                    <button type="submit" class="btn" >Cadastrar</button>
                    <button type="button" class="btn cancel" onclick="fecharForm('cadastro')">Fechar</button>
                    <p>Já tem conta?<a href="#" onclick="abrirForm('login')">Faça Login</a></p>
                </form>
                </div>
            </div>
        </div>
    </div>
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

        <br><br>
        <!-- Avaliações  -->
<section class="avaliacao" id="avaliacao">
    <br>
    <h3> &#9824; Avaliações &#9824;</h3>
    <h4>Confira o que dizem nossos clientes:</h4>
    <form method="get" class="filter-form">
        <select name="ordemAva" onchange="this.form.submit()">
            <option value="recentes" <?= $ordemAva == 'recentes' ? 'selected' : '' ?>>Mais recentes</option>
            <option value="antigas" <?= $ordemAva == 'antigas' ? 'selected' : '' ?>>Mais antigas</option>
            <option value="melhores" <?= $ordemAva == 'melhores' ? 'selected' : '' ?>>Melhores avaliações</option>
            <option value="piores" <?= $ordemAva == 'piores' ? 'selected' : '' ?>>Piores avaliações</option>
        </select>
    </form>
    <div class="conteiner-avaliacao">
        <?php foreach ($avaliacoes as $a){ ?>
            <div class="card-avaliacao">
                <h5><?= ($a['nome']) ?></h5>
                <p class="stars">
                    <?php for ($i = 0; $i < (int)$a['estrelas']; $i++){ ?>
                        ★
                    <?php }?>
                    </p>
                <p><?= ($a['comentario']) ?></p>
            </div>
        <?php } ?>
    </div>
</section>

        <section id="meio">
            <div class="meio">
                <br>
                <h1>&#9824; Quem Somos &#9824;</h1>
                <img src="imgs/quemsomos.png" alt="Caderno Mørk" class="imgeesq">
                <div class="texto">
                    <p>Mørk foi criada para quem não se encaixa nos padrões e busca algo diferente. Desenvolvemos cadernos, diários e fichários autorais, com design elegante e detalhes pensados para inspirar criatividade e identidade própria. Aqui, cada produto nasce para suprir a necessidade de quem quer mais personalidade e liberdade na sua papelaria.</p><br><br><br>
                </div>
            </div>
        </section>

        <!-- Contato -->
         <section id="contato">
            <h1>&#9824; Fale Conosco &#9824; </h1>
            <p>Entre em contato conosco preenchendo o formulário abaixo ou através de nossas redes sociais!</p>
                <form action="msgUser.php" method="post" class="formulario">
                    <input type="text" name ="nome" placeholder="Seu nome" required>
                    <input type="email" name ="email" placeholder="Seu e-mail" required>
                    <textarea name ="mensagem" placeholder="Escreva sua mensagem aqui..." required></textarea>
                    <button type="submit" class="button">Enviar</button>
                </form>
        </section>

    </main>

    <footer class="rodape">
        <div class="rodape-container">
        
            <div class="rodape-coluna">
                <h3>Mørk</h3>
                <p>Papelaria Alternativa</p>
            </div>
    
            <div class="rodape-coluna">
                <h4>Links Rápidos</h4>
                <ul>
                <li><a href="#topo">Login</a></li>
                <li><a href="#meio">Produtos</a></li>
                <li><a href="#galeria">Sobre</a></li>
                <li><a href="#contato">Contato</a></li>
                </ul>
            </div>
    
            <div class="rodape-coluna">
                <h4>Contato</h4>
                <p>Rua Mørkana, 123 - Centro</p>
                <p>(13) 99760-4888</p>
                <p>contato@mørk.com</p>
            </div>
        
            <div class="rodape-coluna">
                <h4>Redes Sociais</h4>
                    <div class="redes-sociais">
                        <a href="https://www.instagram.com" target="_blank" aria-label="Instagram">
                        <img src="https://cdn-icons-png.flaticon.com/128/1419/1419647.png" alt="Instagram" >
                    
                        <a href="https://www.facebook.com" target="_blank" aria-label="Facebook">
                        <img src="https://cdn-icons-png.flaticon.com/128/733/733603.png" alt="Facebook" >
                        </a>
                    
                        <a href="https://wa.me/13997604888" target="_blank" aria-label="WhatsApp">
                        <img src="https://cdn-icons-png.flaticon.com/128/3536/3536479.png" alt="WhatsApp" >
                        </a>
                    </div>
            </div>
    
            </div>
        
            <div class="rodape-direitos">
            <p>&copy; 2025 Mørk | Todos os direitos reservados.</p>
            </div>
  </footer>
 </body>
</html>
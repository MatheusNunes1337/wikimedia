<?php
  session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <?php require_once('includes/componentes/cabecalho.php') ?>
  <title>Contato</title>
</head>
<body class="container-fluid bg-light">
  	<?php require_once('includes/componentes/nav.php') ?>
    <div class="row" id="tchau">
      <?php require_once('includes/componentes/aside.php') ?>
      <main class="principal bg-light">
            <content class="container-fluid py-5 row col-11 mx-auto" style="min-height: auto;">
            <h2 class="mb-4 mt-5 text-lg-left text-center">Sobre o wikimedia</h2>
            <p class="text-justify" style="font-size: 1.2rem;">
              O wikimedia é um sistema direcionado para a área educacional, que no seu âmago
              possui como objetivo compartilhar informações interdisciplinares entre usuários,
              permitindo não só estudar o conteúdo em si, como também partilhar técnicas de
              aprendizagem caso a maioria dos integrantes da sala criada esteja no mesmo nível
              de conhecimento. Portanto, é um software voltado com o intuito de possibilitar que o
              usuário encontre salas de estudo, com a finalidade de comunicar-se com outras
              pessoas cadastradas no sistema, afim de sanar suas necessidades sobre
              determinado assunto e além disso, elevar o seu conhecimento junto com os demais.
            </p>
            <p class="text-justify" style="font-size: 1.2rem;">
              Muitas vezes o ambiente escolar não é suficiente para sanar todas as dúvidas
              de um estudante, por conta disso, surgem diversas dúvidas e dificuldades na
              compreensão de determinado conteúdo. Dessa forma, o wikimedia possibilitará que
              o usuário consiga encontrar salas de estudo para conseguir estudar com diversos
              outros usuários cadastrados.
            </p>  
            </content>    
      </main>
    </div>
    <?php require_once('includes/componentes/modais.php') ?> 
    <?php require_once('includes/componentes/rodape.php') ?>
</body>
</html>



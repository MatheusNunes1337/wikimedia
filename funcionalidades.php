<?php
  session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <?php require_once('includes/componentes/cabecalho.php') ?>
  <title>Funcionalides</title>
</head>
<body class="container-fluid bg-light">
    <?php require_once('includes/componentes/nav.php') ?>
    <div class="row" id="tchau">
      <?php require_once('includes/componentes/aside.php') ?>
      <main class="principal bg-light my-custom-scrollbar">
            <content class="container-fluid py-5 row col-11 mx-auto" style="min-height: auto;">
            <h2 class="row col-12 mb-4 mt-5 text-lg-left text-center">Funcionalidades</h2>
              <h3 class="row col-12 mb-4 mt-5 text-lg-left">Criação de salas de estudo</h3>
              <p class="text-justify" style="font-size: 1.2rem;">
                Com um simples formulário você é capaz de criar uma sala de estudo conforme as suas necessidades. 
              </p>
              <h3 class="row col-12 mb-4 mt-5 text-lg-left">Busca por salas</h3>
              <p class="text-justify" style="font-size: 1.2rem;">
                Não quer criar uma sala, mas sim participar de uma já existente? Isto não é um problema, busque por salas informando a disciplina desejada através de uma barra de buscas. 
              </p>
              <h3 class="row col-12 mb-4 mt-5 text-lg-left">Criação de publicações</h3>
              <p class="text-justify" style="font-size: 1.2rem;">
               Possui dúvidas sobre um determinado tópico, não se preocupe, crie publicações pedindo ajuda e seus colegas irão te ajudar. 
              </p>
              <h3 class="row col-12 mb-4 mt-5 text-lg-left">Compartilhamento de mídias</h3>
              <p class="text-justify" style="font-size: 1.2rem;">
               Você pode compartilhar mídias com os seus colegas para auxiliar com os estudos. Mas cuidado, nem todos os tipos de arquivos ainda são permitidos na nossa plataforma. É possivel compartilhar apenas mídias com as seguintes extensões:
               <strong>.gif, .jpg , .jpeg , .bmp, .GIF, .png, .docx, .pdf, .txt, .xlsx, .odt, .ods</strong> 
              </p
            </content>    
      </main>
    </div>
    <?php require_once('includes/componentes/modais.php') ?> 
    <?php require_once('includes/componentes/rodape.php') ?>
</body>
</html>



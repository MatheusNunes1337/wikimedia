<?php
  session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <?php require_once('includes/componentes/cabecalho.php') ?>
  <title>Atualizações</title>
</head>
<body class="container-fluid bg-light">
    <?php require_once('includes/componentes/nav.php') ?>
    <div class="row" id="tchau">
      <?php require_once('includes/componentes/aside.php') ?>
      <main class="principal bg-light">
            <content class="container-fluid py-5 row col-11 mx-auto" style="min-height: auto;">
            <h2 class="row col-12 mb-4 mt-5 text-lg-left text-center">Atualizações</h2>
              <p class="text-justify" style="font-size: 1.2rem;">
                Atualmente o wikimedia se encontra na versão de protótipo. Quando houver alguma atualização, te avisaremos antecipadamente.
              </p>
            </content>    
      </main>
    </div>
    <?php require_once('includes/componentes/modais.php') ?> 
    <?php require_once('includes/componentes/rodape.php') ?>
</body>
</html>



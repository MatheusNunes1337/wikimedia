<!DOCTYPE html>
<html>
<head>
  <?php require_once('includes/componentes/cabecalho.php') ?>
  <title>Solcitações</title>
</head>
<body class="container-fluid bg-light" onload="listarUsuarios()">
    <?php require_once('includes/componentes/nav.php') ?>
    <div class="row" id="tchau">
      <?php require_once('includes/componentes/aside.php') ?>
      <main class="container-fluid col-xl-10 py-5 col-lg-9 col-12 bg-light">
           <content class="d-flex flex-column container-fluid py-5 row col-11 mx-auto" id="gerenciar_membros" style="min-height: auto;">
           		<h1 class="col-12 text-sm-left text-center mb-3">Gerência de membros</h1>        
           </content>  
      </main>
    </div>
    <?php require_once('includes/componentes/rodape.php') ?>
</body>
</html>
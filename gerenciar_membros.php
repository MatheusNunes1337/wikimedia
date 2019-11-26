<?php
  session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <?php require_once('includes/componentes/cabecalho.php') ?>
  <title>Gerenciar membros</title>
</head>
<body class="container-fluid bg-light" onload="listarUsuarios()">
    <?php require_once('includes/componentes/nav.php') ?>
    <div class="row" id="tchau">
      <?php require_once('includes/componentes/aside.php') ?>
      <main class="container-fluid col-xl-10 py-5 col-lg-9 col-12 bg-light">
           <content class="d-flex flex-column container-fluid py-5 row col-11 mx-auto" id="sala_membros" style="min-height: auto;">
           		<h1 class="text-sm-left text-center mb-5">Gerência de membros</h1> 
              <table class="table mt-4 col-xl-8 col-12 table-bordered" id="table_members" style="display: none;">
                <thead class="thead-dark">
                    <tr align="center">
                      <th scope="col" class="align-middle">Imagem</th>
                      <th scope="col" class="align-middle">Nome de usuário</th>
                      <th scope="col" class="align-middle">Ações</th>
                    </tr>
                </thead>
              </table>           
           </content>  
      </main>
    </div>
    <?php require_once('includes/componentes/modais.php') ?>
    <?php require_once('includes/componentes/rodape.php') ?>
</body>
</html>
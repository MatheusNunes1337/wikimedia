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
      <main class="principal py-5 bg-light my-custom-scrollbar">
           <content class="d-flex flex-column container-fluid py-5 row col-11 mx-auto" id="sala_membros" style="min-height: auto;">
           		<h2 class="text-sm-left text-center mb-5 mt-5">Gerência de membros</h2> 
              <table class="table mt-4 col-xl-8 col-12 table-bordered" id="table_members" style="display: none;">
                <thead style="background: #0b1a21;">
                    <tr align="center">
                      <th scope="col" class="align-middle text-white">Imagem</th>
                      <th scope="col" class="align-middle text-white">Nome de usuário</th>
                      <th scope="col" class="align-middle text-white">Ações</th>
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
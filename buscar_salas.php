<?php
  session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <?php require_once('includes/componentes/cabecalho.php') ?>
  <title>Buscar salas</title>
</head>
<body class="container-fluid bg-light">
    <?php require_once('includes/componentes/nav.php') ?>
    <div class="row" id="tchau">
        <?php require_once('includes/componentes/aside.php') ?>
        <main class="container-fluid col-xl-10 py-5 col-lg-9 col-12 bg-light">
              <content class="container-fluid py-5 row col-11 mx-auto" id="container" style="min-height: auto;">
                <h1 class="row col-12 mb-4">Busca de salas</h1>
                  <div class="input-group bg-white mt-3 col-12 col-xl-7 mb-5 py-2  shadow-sm rounded">
                      <input type="text" class="form-control" name="disciplina" id="search_room" placeholder="Digite a disciplina" style="height: 55px;">
                      <span class="my-auto ml-3 input-group-btn">
                          <button class="btn btn-success" onclick="buscarSala();" type="button">
                              buscar
                          </button>
                      </span>
                  </div>
              </content>    
        </main>
    </div>
     <?php require_once('includes/componentes/rodape.php') ?>
</body>
</html>



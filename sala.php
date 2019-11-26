<?php
  session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <?php require_once('includes/componentes/cabecalho.php') ?>
  <title>Feed</title>
</head>
<body class="container-fluid bg-light">
    <?php require_once('includes/componentes/nav.php') ?>
    <div class="row" id="tchau">
      <?php require_once('includes/componentes/aside.php') ?>
      <main class="container-fluid col-xl-10 py-5 col-lg-9 col-12 bg-light">
           <content class="d-flex flex-column container-fluid py-5 row col-11 mx-auto" id="container" style="min-height: auto;">
           		<div class="input-group bg-white mt-3 col-12 col-xl-7 mb-5 py-2  shadow-sm rounded">
                  <input type="text" class="form-control" name="postagem" id="search_post" placeholder="Buscar postagem" style="height: 55px;">
                  <span class="my-auto ml-3 input-group-btn">
                      <button class="btn btn-success" onclick="buscarSala();" type="button">
                          buscar
                      </button>
                  </span>
              </div>
              <div class="d-flex align-items-center">
                <img src="" id="imagem_perfil" alt="profile_image" class="img-thumbnail rounded-circle" style="width: 60px; height: 60px;">
                <span>Matheus Nunes</span>
              </div>
              <div class="form-group mt-3 col-12 col-xl-7 mb-5 py-2">
                  <textarea class="form-control bg-white" rows="4" maxlength="800" style="min-width: 100%">O wikimedia é mais divertido quando coisas são compartilhadas</textarea>
                  <div class="row input-group mt-3"></div>
                    <span class="btn btn-file" style="background: #0b1a21;">
                        <i class="fas fa-file-word text-white" style="font-size: 22px;"></i> <input type="file">
                    </span>
                    <span class="btn btn-file ml-2" style="background: #0b1a21;">
                        <i class="fas fa-file-word text-white" style="font-size: 22px;"></i> <input type="file">
                    </span>
                    <span class="btn btn-file  ml-2" style="background: #0b1a21;">
                        <i class="fas fa-file-word text-white" style="font-size: 22px;"></i> <input type="file">
                    </span>
                    <span class="btn btn-file  ml-2" style="background: #0b1a21;">
                        <i class="fas fa-file-word text-white" style="font-size: 22px;"></i> <input type="file">
                    </span>
                  </div>
                  <div class="input-group">
                      <button class="btn btn-danger">Publicar</button>
                  </div>  
              </div>
              <div id="feed" class="mt-3 col-12 col-xl-10 py-3 bg-success" style="min-height: 500px;">
                
              </div>  
           </content>  
      </main>
    </div>
    <?php require_once('includes/componentes/modais.php') ?> 
    <?php require_once('includes/componentes/rodape.php') ?>
</body>
</html>








<?php
  session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <?php require_once('includes/componentes/cabecalho.php') ?>
  <title>Configurações do perfil</title>
</head>
<body class="container-fluid bg-light">
  	<?php require_once('includes/componentes/nav.php') ?>
    <div class="row" id="tchau">
      <?php require_once('includes/componentes/aside.php') ?>
      <main class="container-fluid col-xl-10 py-5 col-lg-9 col-12 bg-light">
            <content class="container-fluid py-5 row col-11 mx-auto" style="min-height: auto;">
              <form class="col-12 col-lg-4">
                  <h2 class="mb-4 text-lg-left text-center">Configurações do perfil</h2>
                  <img src="includes/componentes/imagens/usuarios/matheus.jpg" alt="profile_image" class="img-fluid img-thumbnail rounded-circle mb-4 ml-lg-0 mt-3 mx-auto d-lg-inline d-block" style="width: 200px; height: 200px;">
                  <div class="form-group">
                      <input type="file" class="form-control-file">
                  </div>
                  <div class="form-group">
                    <label for="email_att">Endereço de email</label>
                    <input type="email" class="form-control" id="email_att" aria-describedby="emailHelp" placeholder="Seu email">
                    <small id="emailHelp" class="form-text text-muted">Nunca vamos compartilhar seu email, com ninguém.</small>
                  </div>
                  <div class="form-group">
                    <label for="senha_att">Senha</label>
                    <input type="password" class="form-control" id="senha_att" placeholder="Senha">
                  </div>
                  <button type="submit" class="btn btn-success">Atualizar</button>
              </form>
            </content>    
      </main>
    </div>
    <?php require_once('includes/componentes/rodape.php') ?>
</body>
</html>



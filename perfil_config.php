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
            <script>userConfig();</script>
            <content class="container-fluid py-5 row col-11 mx-auto" style="min-height: auto;">
            <h2 class="col-12 mb-4 text-lg-left text-center">Configurações do perfil</h2>
              <form class="col-12 col-lg-4" id="profile_config" onsubmit="editarConta();" name="perfilEditForm">
                  <img src="" id="user_image" alt="profile_image" class="img-fluid img-thumbnail rounded-circle mb-4 ml-lg-0 mt-3 mx-auto d-lg-inline d-block user_image" style="width: 130px; height: 130px;">
                  <div class="form-group">
                      <input type="file" class="form-control-file" name="user_foto">
                  </div>
                  <div class="form-group">
                    <label for="username_att">Nome de usuário</label>
                    <input type="text" class="form-control" id="username_att" aria-describedby="usernameHelp" placeholder="Seu nome de usuário"
                    name="user_username">
                    <small id="usernameHelp" class="form-text text-muted d-none">Nunca vamos compartilhar seu email, com ninguém.</small>
                  </div>
                  <div class="form-group">
                    <label for="email_att">Endereço de email</label>
                    <input type="email" class="form-control" id="email_att" aria-describedby="emailHelp" placeholder="Seu email"
                    name="user_email">
                    <small id="emailHelp" class="form-text text-muted d-none">Nunca vamos compartilhar seu email, com ninguém.</small>
                  </div>
                  <div class="form-group">
                    <label for="senha_att">Senha</label>
                    <input type="password" class="form-control" id="senha_att" placeholder="Senha" name="user_senha" aria-describedby="senhaHelp">
                    <small id="senhaHelp" class="form-text text-muted d-none">Nunca vamos compartilhar seu email, com ninguém.</small>
                  </div>
                  <button type="submit" class="btn btn-success">Atualizar</button>
                  <button type="button" class="btn btn-danger" onclick="excluirConta();">Excluir conta</button>
              </form>
            </content>    
      </main>
    </div>
    <?php require_once('includes/componentes/modais.php') ?> 
    <?php require_once('includes/componentes/rodape.php') ?>
</body>
</html>



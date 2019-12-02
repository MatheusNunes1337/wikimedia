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
      <main class="principal bg-light">
            <content class="container-fluid py-5 row col-11 mx-auto" style="min-height: auto;">
            <h2 class="col-12 mb-5 mt-5 text-lg-left text-center">Configurações do perfil</h2>
              <form class="col-12 col-lg-4" id="profile_config" onsubmit="editarConta();" name="perfilEditForm">
                  <img src="" id="user_image" alt="profile_image" class="img-fluid img-thumbnail rounded-circle mb-2 ml-lg-0 mt-3 mx-auto d-lg-inline d-block user_image" style="width: 150px; height: 150px;">
                  
                  <span class="btn btn-file mt-lg-2 mt-3 mb-4 d-block col-xl-6 col-9 text-white ml-lg-0 mx-auto" style="background: #0b1a21;">
                      Mudar imagem<input type="file" name="user_foto">
                  </span>
                  <div class="form-group">
                    <label for="username_att">Nome de usuário</label>
                    <input type="text" class="form-control" id="username_att" aria-describedby="usernameHelp" placeholder="Seu nome de usuário"
                    name="user_username" onfocusout="verificaUsuario(event)" required="true" pattern=".{6,12}">
                    <small id="username_msg" class="form-text text-muted d-none">Nunca vamos compartilhar seu email, com ninguém.</small>
                  </div>
                  <div class="form-group">
                    <label for="email_att">Endereço de email</label>
                    <input type="email" class="form-control" id="email_att" aria-describedby="emailHelp" placeholder="Seu email"
                    name="user_email" onfocusout="verificaEmail(event)" required="true">
                    <small id="email_msg" class="form-text text-muted d-none">Nunca vamos compartilhar seu email, com ninguém.</small>
                  </div>
                  <div class="form-group">
                    <label for="senha_att">Senha</label>
                    <input type="password" class="form-control" id="senha_att" placeholder="Senha" name="user_senha" aria-describedby="senhaHelp" onfocusout="verificaSenha(event)" required="true" pattern=".{6,12}">
                    <small id="senha_msg" class="form-text text-muted d-none">Nunca vamos compartilhar seu email, com ninguém.</small>
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


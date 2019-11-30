<?php
  session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <?php require_once('includes/componentes/cabecalho.php') ?>
  <title>Contato</title>
</head>
<body class="container-fluid bg-light">
  	<?php require_once('includes/componentes/nav.php') ?>
    <div class="row" id="tchau">
      <?php require_once('includes/componentes/aside.php') ?>
      <main class="principal bg-light">
            <content class="container-fluid py-5 row col-11 mx-auto" style="min-height: auto;">
            <h2 class="col-12 mb-4 text-lg-left text-center">Contato</h2>
              <form class="col-12 col-lg-4" id="contact_form">
                  <div class="form-group">
                    <label for="username_att">Nome completo</label>
                    <input type="text" class="form-control" id="username_att" aria-describedby="usernameHelp" placeholder="Seu nome de usuário"
                    name="user_username">
                  </div>
                  <div class="form-group">
                    <label for="email_att">Endereço de email</label>
                    <input type="email" class="form-control" id="email_att" aria-describedby="emailHelp" placeholder="Seu email"
                    name="user_email">
                  </div>
                  <div class="form-group">
                    <label for="senha_att">Mensagem</label>
                     <textarea class="form-control bg-white" rows="4" maxlength="800" style="min-width: 100%" name="post_text" placeholder="Digite aqui a sua mensagem"></textarea>
                  </div>
                  <button type="submit" class="btn btn-success">Enviar</button>
                  <button type="reset" class="btn btn-danger"">Cancelar</button>
              </form>
            </content>    
      </main>
    </div>
    <?php require_once('includes/componentes/modais.php') ?> 
    <?php require_once('includes/componentes/rodape.php') ?>
</body>
</html>



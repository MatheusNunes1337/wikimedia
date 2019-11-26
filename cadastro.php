<?php  
  session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <?php require_once('includes/componentes/cabecalho.php') ?>
    <title>Cadastro</title>
</head>
<body class="container-fluid bg-light d-flex align-items-center justify-content-center">
<div class="col-12 col-sm-9 col-lg-3 col-md-7">  	
    <form class="col-12 py-3 bg-white shadow-sm rounded" action="includes/logica/logica_usuario.php" method="POST" name="cadastro">
        <h1 class="mb-5 mt-4 text-center">Registro</h1>
        <div class="form-group col-11 mx-auto">
         
          <input type="text" class="form-control" name="username" id="username" aria-describedby="username_msg" placeholder="Nome de usuário" onfocusout="verificaUsuario(event)" required="true" pattern=".{6,12}" style="height: 45px;">
          <small id="username_msg" class="form-text text-muted">Digite um nome de usuário de 6 a 12 caracteres.</small>
        </div>
        <div class="form-group col-11 mx-auto">
          
          <input type="email" class="form-control" name="email" id="email" aria-describedby="email_msg" placeholder="Email" onfocusout="verificaEmail(event)" required="true" style="height: 45px;">
          <small id="email_msg" class="form-text text-muted">Nunca vamos compartilhar seu email, com ninguém.</small>
        </div>
        <div class="form-group col-11 mx-auto">
          <input type="password" class="form-control" name="senha" id="senha" placeholder="Senha" aria-describedby="senha_msg" onfocusout="verificaSenha(event)" required="true" pattern=".{6,12}" style="height: 45px;">
          <small id="senha_msg" class="form-text text-muted">Digite uma de 6 a 12 caracteres.</small>
        </div>
         <div class="form-group col-11 mx-auto">
          <input type="submit" class="form-control bg-danger text-light mt-4 mb-4" value="Cadastrar" name="cadastrar" style="height: 45px;">
        </div>
    </form>
    <p class="text-center mt-3">Já possui uma conta?<a href="login.php" class="ml-2 text-danger">Entrar</a></p>
</div>

<?php require_once('includes/componentes/rodape.php') ?>
</body>
</html>



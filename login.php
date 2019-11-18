<?php  
  session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <?php require_once('includes/componentes/cabecalho.php') ?>
  <title>Entrar</title>
</head>
<body class="container-fluid d-flex align-items-center justify-content-center bg-light">
<div class="col-12 col-sm-9 col-lg-3 col-md-7">  	
    <form class="col-12 py-3 bg-white shadow-sm rounded" action="includes/logica/logica_usuario.php" method="POST">
        <h1 class="mb-5 mt-4 text-center">Entrar</h1>
        <div class="form-group col-11 mx-auto">
          <input type="text" class="form-control" name="username" placeholder="Nome de usuário" onfocusout="verificaUsuario(event)" required="true" style="height: 45px;">
        </div>
        <div class="form-group col-11 mx-auto">
          <input type="password" class="form-control" name="senha" placeholder="Senha" aria-describedby="senha_msg" onfocusout="verificaSenha(event)" required="true" style="height: 45px;">
        </div>
         <div class="form-group col-11 mx-auto">
          <input type="submit" class="form-control bg-danger text-light mt-4 mb-4" value="Entrar" name="logar" style="height: 45px;">
        </div>
    </form>
    <p class="text-center mt-3">É novo por aqui?<a href="cadastro.php" class="ml-2 text-danger">Cadastre-se</a></p>
</div>

<?php require_once('includes/componentes/rodape.php') ?>
</body>
</html>



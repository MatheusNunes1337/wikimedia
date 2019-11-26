<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<?php require_once('includes/componentes/cabecalho.php') ?>
  <title>Página inicial</title>
</head>
<body class="container-fluid bg-light">
  	<?php require_once('includes/componentes/nav.php') ?>
    <div class="row" id="tchau">
      <?php require_once('includes/componentes/aside.php') ?>
      <main class="container-fluid col-xl-10 py-5 col-lg-9 col-12 bg-light">
            <content class="container-fluid py-5 row col-11 mx-auto" style="min-height: auto;">
                <div class="jumbotron col-12 bg-white shadow-sm">
                    <h1 class="display-4">Olá, bem vindo ao Wikimedia!</h1>
                    <p class="lead">Este é um simples componente jumbotron para chamar mais atenção a um determinado conteúdo ou informação.</p>
                    <hr class="my-4">
                    <p>Ele usa classes utilitárias para tipografia e espaçamento de conteúdo, dentro do maior container.</p>
                    <a class="btn btn-danger btn-lg" href="#" role="button">Leia mais</a>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4 mb-3 mb-md-0">
                      <div class="card border-white shadow-sm">
                        <div class="card-body">
                          <h5 class="card-title">Sobre</h5>
                          <p class="card-text">Com suporte a texto embaixo, que funciona como uma introdução a um conteúdo adicional.</p>
                          <a href="#" class="btn btn-danger">Leia mais</a>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                      <div class="card border-white shadow-sm">
                        <div class="card-body">
                          <h5 class="card-title">Contato</h5>
                          <p class="card-text">Com suporte a texto embaixo, que funciona como uma introdução a um conteúdo adicional.</p>
                          <a href="#" class="btn btn-danger">Leia mais</a>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                      <div class="card border-white shadow-sm">
                        <div class="card-body">
                          <h5 class="card-title">Título especial</h5>
                          <p class="card-text">Com suporte a texto embaixo, que funciona como uma introdução a um conteúdo adicional.</p>
                          <a href="#" class="btn btn-danger">Leia mais</a>
                        </div>
                      </div>
                    </div>
                </div>
            </content>
      </main>
    </div>
    <?php require_once('includes/componentes/modais.php') ?>
    <?php require_once('includes/componentes/rodape.php') ?>
</body>
</html>


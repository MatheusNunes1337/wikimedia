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
      <main class="bg-light principal py-auto mx-auto">
            <content class="container-fluid py-5 row col-11 mx-auto" style="min-height: auto;">
                <div class="jumbotron col-12 bg-white shadow-sm">
                    <h1 class="display-4">Olá, bem vindo ao Wikimedia!</h1>
                    <p class="lead">Crie salas de estudo e comece a estudar o quanto antes.</p>
                    <hr class="my-4">
                    <p>Quer saber mais sobre as funcionalidades da nossa plataforma? Clique no botão logo abaixo</p>
                    <a class="btn btn-danger btn-lg botao_transition" href="funcionalidades.php" role="button">Leia mais</a>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4 mb-3 mb-md-0">
                      <div class="card border-white shadow-sm">
                        <div class="card-body">
                          <h5 class="card-title">Sobre</h5>
                          <p class="card-text">Quer saber o porquê do wikimedia ter sido criado? Nessa sessão são dadas todas as informações referentes a isso.</p>
                          <a href="sobre.php" class="btn btn-danger botao_transition">Leia mais</a>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                      <div class="card border-white shadow-sm">
                        <div class="card-body">
                          <h5 class="card-title">Contato</h5>
                          <p class="card-text">Possui alguma dúvida sobre o wikimedia? Não tem problema, o link abaixo irá te ajudar.</p>
                          <a href="form_contato.php" class="btn btn-danger botao_transition">Leia mais</a>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                      <div class="card border-white shadow-sm">
                        <div class="card-body">
                          <h5 class="card-title">Atualizações</h5>
                          <p class="card-text">Fique por dentro de todas as atualizações que ocorrem na nossa plataforma.</p>
                          <a href="atualizacoes.php" class="btn btn-danger botao_transition">Leia mais</a>
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


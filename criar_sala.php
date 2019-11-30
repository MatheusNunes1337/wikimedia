<?php
  session_start();
?>
<!DOCTYPE html>
<html>
<head>
      <?php require_once('includes/componentes/cabecalho.php') ?>
      <title>Criar uma sala</title>
</head>
<body class="container-fluid bg-light">
  	<?php require_once('includes/componentes/nav.php') ?>
    <div class="row" id="tchau">
      <?php require_once('includes/componentes/aside.php') ?>
      <main class="principal bg-light">
            <content class="container-fluid py-5 row col-11 mx-auto" style="min-height: auto">
                <form class="col-md-6 col-12" method="POST" action="includes/logica/logica_sala.php">
                    <h2 class="text-dark mb-5">Criar uma sala</h2>
                    <div class="form-group">
                      <label for="nome_sala">Nome da sua sala</label>
                      <input type="text" class="form-control" id="nome_sala" name="sala_nome" aria-describedby="nome_status" placeholder="Nome da sua sala">
                      <small id="nome_status" class="form-text text-muted" style="opacity: 0;">Nunca vamos compartilhar seu email, com ninguém.</small>
                    </div>
                    <div class="form-group">
                      <label for="descricao_sala">Descrição</label>
                      <textarea class="form-control" name="sala_descricao" rows="5" id="descricao_sala" maxlength="200" placeholder="Insira uma descricao para sua sala"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="nivel_sala">Selecione o nível</label>
                        <select class="form-control" id="nivel_sala" name="sala_nivel">
                            <label for="nivel_sala">Selecione o nível</label>
                            <option value="iniciante">Iniciante</option>
                            <option value="Intermediario">Intermediário</option>
                            <option value="avançado">Avançado</option>
                            <option value="mestre">Mestre</option>
                        </select>
                    </div>
                    <div class="form-group">
                      <label for="membros_sala">Nº máximo de membros</label>
                      <input type="text" class="form-control" id="membros_sala" name="sala_membros" aria-describedby="sala_membros" placeholder="insira o número máximo de membros que sua sala poderá conter">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <label for="disciplina_sala">Disciplina</label>
                            <input type="text" class="form-control" name="sala_disciplina" id="disciplina_sala" placeholder="Ex: Matemática">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="conteudo_sala">Conteudo</label>
                            <input type="text" class="form-control" id="conteudo_sala" name="sala_conteudo" placeholder="Ex: Trigonometria">
                        </div>
                    </div>
                    <button type="submit" name="criar_sala" class="mt-3 btn btn-success">Criar</button>
                    <button type="reset" class="mt-3 ml-2 btn btn-danger" value="Reset">Cancelar</button>
                </form>
            </content>
      </main>
    </div>
    <?php require_once('includes/componentes/modais.php') ?>
    <?php require_once('includes/componentes/rodape.php') ?>
</body>
</html>



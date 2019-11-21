<?php
  session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <?php require_once('includes/componentes/cabecalho.php') ?>
  <title>Configurações da sala</title>
</head>
<body class="container-fluid bg-light">
    <?php require_once('includes/componentes/nav.php') ?>
    <div class="row" id="tchau">
      <?php require_once('includes/componentes/aside.php') ?>
      <main class="container-fluid col-xl-10 py-5 col-lg-9 col-12 bg-light">
           <content class="d-flex flex-column container-fluid py-5 row col-11 mx-auto" style="min-height: auto;">
                 <h1 class="col-12 mb-5">Configurações da sala</h1>
                <form class="col-xl-6 col-md-10 col-12 mb-5" method="POST" action="includes/logica/logica_sala.php">
                    <h3 class="text-dark mb-5 mt-3">Alterar informações</h3>
                    <div class="form-group">
                      <label for="nome_sala">Nome da sua sala</label>
                      <input type="text" class="form-control" id="nome_sala" name="sala_nome" aria-describedby="nome_status" placeholder="Nome da sua sala">
                      <small id="nome_status" class="form-text text-muted" style="opacity: 1;">Nunca vamos compartilhar seu email, com ninguém.</small>
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
                            <option value="avancado">Avançado</option>
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
                    <button type="submit" name="criar_sala" class="mt-3 btn btn-success">Atualizar</button>
                    <button type="reset" class="mt-3 ml-2 btn btn-danger" value="Reset">Cancelar</button>
                </form>
                <form class="col-12 col-xl-3 col-md-10 col-lg-6 mb-5" method="POST" action="includes/logica/logica_sala.php">
                    <h3 class="text-dark mb-2 mt-3">Deletar sala</h3>
                    <p>Atenção: Uma vez que você realize a operação abaixo, não há como voltar atrás. Dito isso, digite sua senha abaixo para confirmar sua autenticação, caso contrário, clique em cancelar.</p>
                    <div class="form-group">
                      <label for="user_pass">Senha</label>
                      <input type="password" class="form-control" id="user_pass" name="sala_nome" aria-describedby="pass_status" placeholder="Digite a sua senha">
                      <small id="pass_status" class="form-text text-muted" style="opacity: 1;">Nunca vamos compartilhar seu email, com ninguém.</small>
                    </div>
                    <button type="submit" name="deletar_sala" class="btn btn-success">Concluir</button>
                    <button type="reset" class="ml-2 btn btn-danger" value="Reset">Cancelar</button>
                </form>     
           </content>  
      </main>
    </div>
    <?php require_once('includes/componentes/rodape.php') ?>
</body>
</html>


<?php
  session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <?php require_once('includes/componentes/cabecalho.php') ?>
  <title>Configurações da sala</title>
</head>
<body class="container-fluid bg-light" onload="acharSala();">
    <?php require_once('includes/componentes/nav.php') ?>
    <div class="row" id="tchau">
      <?php require_once('includes/componentes/aside.php') ?>
      <main class="principal bg-light my-custom-scrollbar">
           <content class="d-flex flex-column container-fluid py-5 row col-11 mx-auto" style="min-height: auto;">
                 <h2 class="col-12 mb-5 mt-5">Configurações da sala</h2>
                <form class="col-xl-6 col-md-10 col-12 mb-5" action="includes/logica/logica_sala.php" id="editRoom" onsubmit="editaSala();" name="formEditSala">
                    <h3 class="text-dark mb-5 mt-3">Alterar informações</h3>
                    <div class="form-group">
                      <label for="nome_sala">Nome da sua sala</label>
                      <input type="text" class="form-control" id="nome" name="sala_nome" aria-describedby="nome_status" placeholder="Nome da sua sala">
                      <small id="nome_status" class="form-text text-muted" style="opacity: 1;">Nunca vamos compartilhar seu email, com ninguém.</small>
                    </div>
                    <div class="form-group">
                      <label for="descricao_sala">Descrição</label>
                      <textarea class="form-control" name="descricao" rows="5" id="descricao_sala" maxlength="200" placeholder="Insira uma descricao para sua sala"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="nivel_sala">Selecione o nível</label>
                        <select class="form-control" id="nivel" name="sala_nivel">
                            <label for="nivel_sala">Selecione o nível</label>
                            <option value="iniciante">Iniciante</option>
                            <option value="Intermediario">Intermediário</option>
                            <option value="avancado">Avançado</option>
                            <option value="mestre">Mestre</option>
                        </select>
                    </div>
                    <div class="form-group">
                      <label for="membros_sala">Nº máximo de membros</label>
                      <input type="text" class="form-control" id="membros_sala" name="membros" aria-describedby="sala_membros" placeholder="insira o número máximo de membros que sua sala poderá conter">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <label for="disciplina_sala">Disciplina</label>
                            <input type="text" class="form-control" name="disciplina" id="disciplina_sala" placeholder="Ex: Matemática">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="conteudo_sala">Conteudo</label>
                            <input type="text" class="form-control" id="conteudo_sala" name="conteudo" placeholder="Ex: Trigonometria">
                        </div>
                    </div>
                    <button type="submit" name="atualizar_sala" class="mt-3 btn btn-success">Atualizar</button>
                    <button type="reset" class="mt-3 ml-2 btn btn-danger" value="Reset">Cancelar</button>
                </form>
                <form class="col-12 col-xl-5 col-md-7 col-lg-6 mb-5" method="POST" action="includes/logica/logica_sala.php">
                    <h3 class="text-dark mb-2 mt-3">Deletar sala</h3>
                    <p>Atenção: Uma vez que você realize a operação abaixo, <strong>não há como voltar atrás</strong>. Dito isso, digite sua senha abaixo para confirmar sua autenticação, caso contrário, clique em cancelar.</p>
                    <div class="form-group">
                      <label for="user_pass">Senha</label>
                      <input type="password" class="form-control" id="user_pass" name="pass_confirm" aria-describedby="pass_status" placeholder="Digite a sua senha" onfocusout="verificaAdmPass(event)"  required="true" pattern=".{6,12}">
                      <small id="pass_status" class="form-text invisible">Nunca vamos compartilhar seu email, com ninguém.</small>
                    </div>
                    <button type="submit" name="deletar_sala" class="btn btn-success disabled" id="deleteRoom">Concluir</button>
                    <button type="reset" class="ml-2 btn btn-danger" value="Reset">Cancelar</button>
                </form>     
           </content>  
      </main>
    </div>
    <?php require_once('includes/componentes/modais.php') ?>
    <?php require_once('includes/componentes/rodape.php') ?>
</body>
</html>



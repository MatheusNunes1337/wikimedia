
<nav class="navbar navbar-dark col-xl-3 col-lg-3 d-none d-lg-block" style="background: #0b1a21;" onload="userAside();">
    <a class="navbar-brand" href="#">Wikimedia</a>
        <div class="row h-auto mt-3 container">
          
            <img src="" id="imagem_perfil" alt="profile_image" class="img-fluid img-thumbnail rounded-circle mb-2 ml-lg-0 mt-4" style="width: 100px; height: 100px;">
         
          <p class="row text-white col-xl-10 col-10 mt-2" id="nome_usuario"></p>
        </div>

      <ul class="navbar-nav py-2 mt-4">
          <li class="nav-header text-white">Geral</li>
          <li class="nav-item">
            <a class="nav-link text-white" href="home.php">
              <span><i class="fas fa-home text-white mr-2"></i></span>
              <span>Página inicial</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="perfil_config.php">
              <span><i class="fas fa-cog text-white mr-2"></i></span>
              <span>Configurações</span>
            </a>
          </li>
          <hr>
          <li class="nav-header text-white">Salas</li>
          <li class="nav-item">
            <a class="nav-link text-white" href="criar_sala.php">Criar uma sala</a>
          </li>
          <li class="nav-item">
              <a class="nav-link text-white" href="minhas_salas.php">
                  <span><i class="fas fa-search mr-2 text-white"></i></span>
                  <span>Minhas salas</span>
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link text-white" href="buscar_salas.php">
                  <span><i class="fas fa-search mr-2 text-white"></i></span>
                  <span>Buscar uma sala</span>
              </a>
          </li>
          <hr>
          <li class="nav-header text-white">Ações</li>
          <li class="nav-item">
              <a class="nav-link text-white" href="gerenciar_membros.php">
                  <span><i class="fas fa-users-cog mr-2 text-white"></i></i></span>
                  <span>Gerenciar membros</span>
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link text-white" href="sala_config.php">
                  <span><i class="fas fa-cog mr-2 text-white"></i></span>
                  <span>Configurações da sala</span>
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link text-white" href="solicitacoes.php">
                  <span><i class="fas fa-cog mr-2 text-white"></i></span>
                  <span>Solicitações</span>
              </a>
          </li>
      </ul>
</nav>